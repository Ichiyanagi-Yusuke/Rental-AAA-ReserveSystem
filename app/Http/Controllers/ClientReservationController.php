<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\ReservationDetail;
use App\Models\Resort;
use App\Models\RentalMenu;
use App\Models\RentalMenuCategory;
use App\Models\BusinessCalendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

// 既存のuseの下に追加
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationCompleted;

class ClientReservationController extends Controller
{
    // 同意画面
    public function agree()
    {
        // セッションクリア
        session()->forget('client_reservation.header');
        session()->forget('client_reservation.details');

        return view('client.reservations.agree');
    }

    // 同意画面POST
    public function storeAgree(Request $request)
    {
        $validated = $request->validate([
            'agree' => ['required', 'accepted'],
        ], [
            'agree.required' => '同意事項への同意が必要です。',
            'agree.accepted' => '同意事項への同意が必要です。',
        ]);

        session(['client_reservation.agreed' => true]);

        return redirect()->route('client.reservation.header');
    }

    // ヘッダー（代表者情報）入力画面
    public function header()
    {
        // 同意していない場合は同意画面へリダイレクト
        if (!session('client_reservation.agreed')) {
            return redirect()->route('client.reservation.agree');
        }

        $resorts = Resort::orderBy('id', 'asc')->get();
        $header = session('client_reservation.header', []);

        return view('client.reservations.header', compact('resorts', 'header'));
    }

    // ヘッダー（代表者情報）POST
    public function storeHeader(Request $request)
    {
        $validated = $request->validate([
            'last_name'        => ['required', 'string', 'max:50'],
            'first_name'       => ['required', 'string', 'max:50'],
            'last_name_f'      => ['required', 'string', 'max:50'],
            'first_name_f'     => ['required', 'string', 'max:50'],
            'tel'              => ['required', 'string', 'max:20'],
            'email'            => ['required', 'email', 'max:255'],
            'reserve_date'     => ['required', 'date', 'after_or_equal:today'],
            'reserve_time'     => ['required', 'date_format:H:i'],
            'return_date'      => ['required', 'date', 'after_or_equal:reserve_date'],
            'resort_id'        => ['required', 'exists:resorts,id'],
            'comment'          => ['nullable', 'string'],
        ], [
            'last_name.required' => '姓を入力してください。',
            'first_name.required' => '名を入力してください。',
            'last_name_f.required' => 'セイを入力してください。',
            'first_name_f.required' => 'メイを入力してください。',
            'tel.required' => '携帯電話番号を入力してください。',
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => '正しいメールアドレスを入力してください。',
            'reserve_date.required' => '来店予定日を選択してください。',
            'reserve_date.after_or_equal' => '来店予定日は本日以降の日付を選択してください。',
            'reserve_time.required' => '来店予定時刻を選択してください。',
            'return_date.required' => '返却予定日を選択してください。',
            'return_date.after_or_equal' => '返却予定日は来店予定日以降の日付を選択してください。',
            'resort_id.required' => 'ゲレンデを選択してください。',
        ]);

        // 営業カレンダーチェック
        $calendar = BusinessCalendar::whereDate('date', $request->reserve_date)->first();

        if (!$calendar || !$calendar->pattern || !$calendar->pattern->is_open) {
            throw ValidationException::withMessages([
                'reserve_date' => 'この日は営業していないため、予約を受け付けていません。',
            ]);
        }

        $pattern = $calendar->pattern;
        $openTime = Carbon::createFromFormat('H:i:s', $pattern->open_time);
        $closeTime = Carbon::createFromFormat('H:i:s', $pattern->close_time);
        $rVisitTime = Carbon::createFromFormat('H:i', $request->reserve_time);

        if ($rVisitTime->lt($openTime) || $rVisitTime->gt($closeTime)) {
            throw ValidationException::withMessages([
                'reserve_time' => '来店予定時刻は営業時間内（' . $openTime->format('H:i') . '〜' . $closeTime->format('H:i') . '）で入力してください。',
            ]);
        }

        // 同一電話番号・同一来店日の重複チェック
        $visitDate = Carbon::parse($validated['reserve_date'])->toDateString();
        $tel = $validated['tel'];

        $exists = Reservation::where('phone', $tel)
            ->whereDate('visit_date', $visitDate)
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'reserve_date' => '指定した日付は既にご予約いただいています。',
            ]);
        }

        // セッションに保存
        $validated['reserve_date'] = $visitDate;
        session(['client_reservation.header' => $validated]);

        return redirect()
            ->route('client.reservation.detail')
            ->with('status', '代表者情報を保存しました。利用者情報を入力してください。');
    }

    // 詳細（利用者情報）入力画面
    public function detail(Request $request)
    {
        $header = session('client_reservation.header');
        if (!$header) {
            return redirect()
                ->route('client.reservation.header')
                ->with('status', '先に代表者情報を入力してください。');
        }

        // バリデーションエラーがある場合は、old()の入力内容を表示
        if ($request->old('guests')) {
            $details = $request->old('guests');
        } elseif ($request->query('edit') === 'single' && $request->query('index') !== null) {
            // 特定の利用者のみを編集
            $sessionDetails = session('client_reservation.details', []);
            $index = $request->query('index');
            if (isset($sessionDetails[$index])) {
                $details = [$sessionDetails[$index]];
                // 編集中のインデックスをセッションに保存
                session(['client_reservation.editing_index' => $index]);
            } else {
                $details = [[
                    'name'            => '',
                    'furigana'        => '',
                    'sex'             => '',
                    'jr'              => false,
                    'tall'            => null,
                    'foot'            => null,
                    'stance_id'       => null,
                    'gear_plan_id'    => null,
                    'wear_plan_id'    => null,
                    'wear_size'       => null,
                    'glove_plan_id'   => null,
                    'glove_size'      => null,
                    'goggles_plan_id' => null,
                    'helmet'          => false,
                    'is_step_on'      => false,
                    'comment'         => '',
                ]];
            }
        } elseif ($request->query('edit') === 'all') {
            // 確認画面から編集モードで戻ってきた場合は、全利用者情報を表示
            $sessionDetails = session('client_reservation.details', []);
            $details = !empty($sessionDetails) ? $sessionDetails : [[
                'name'            => '',
                'furigana'        => '',
                'sex'             => '',
                'jr'              => false,
                'tall'            => null,
                'foot'            => null,
                'stance_id'       => null,
                'gear_plan_id'    => null,
                'wear_plan_id'    => null,
                'wear_size'       => null,
                'glove_plan_id'   => null,
                'glove_size'      => null,
                'goggles_plan_id' => null,
                'helmet'          => false,
                'is_step_on'      => false,
                'comment'         => '',
            ]];
        } else {
            // 通常時は新規入力フォームを表示（1行分の空データ）
            $details = [[
                'name'            => '',
                'furigana'        => '',
                'sex'             => '',
                'jr'              => false,
                'tall'            => null,
                'foot'            => null,
                'stance_id'       => null,
                'gear_plan_id'    => null,
                'wear_plan_id'    => null,
                'wear_size'       => null,
                'glove_plan_id'   => null,
                'glove_size'      => null,
                'goggles_plan_id' => null,
                'helmet'          => false,
                'is_step_on'      => false,
                'comment'         => '',
            ]];
        }

        // メニュー取得
        $categoryMap = RentalMenuCategory::whereIn('name', ['スノーボード', 'スキー', 'ウェア', 'グローブ', 'ゴーグル'])
            ->where('is_active', true)
            ->pluck('id', 'name');

        $boardCategoryId = $categoryMap['スノーボード'] ?? null;
        $skiCategoryId = $categoryMap['スキー'] ?? null;
        $wearCategoryId = $categoryMap['ウェア'] ?? null;
        $gloveCategoryId = $categoryMap['グローブ'] ?? null;
        $goggleCategoryId = $categoryMap['ゴーグル'] ?? null;

        $mainCategoryIds = array_filter([$boardCategoryId, $skiCategoryId]);

        // メインギア（大人）
        $gear_plans_adult = RentalMenu::where('is_active', true)
            ->where('menu_type', 'base')
            ->when($mainCategoryIds, fn($q) => $q->whereIn('rental_menu_category_id', $mainCategoryIds))
            ->where('is_junior', 0)
            ->orderBy('name')
            ->get();

        // メインギア（子供）
        $gear_plans_child = RentalMenu::where('is_active', true)
            ->where('menu_type', 'base')
            ->when($mainCategoryIds, fn($q) => $q->whereIn('rental_menu_category_id', $mainCategoryIds))
            ->where('is_junior', 1)
            ->orderBy('name')
            ->get();

        // ウェア（大人）
        $wear_plans_adult = RentalMenu::where('is_active', true)
            ->when($wearCategoryId, fn($q) => $q->where('rental_menu_category_id', $wearCategoryId))
            ->where('is_junior', 0)
            ->orderBy('name')
            ->get();

        // ウェア（子供）
        $wear_plans_child = RentalMenu::where('is_active', true)
            ->when($wearCategoryId, fn($q) => $q->where('rental_menu_category_id', $wearCategoryId))
            ->where('is_junior', 1)
            ->orderBy('name')
            ->get();

        // グローブ（大人）
        $glove_plans_adult = RentalMenu::where('is_active', true)
            ->when($gloveCategoryId, fn($q) => $q->where('rental_menu_category_id', $gloveCategoryId))
            ->where('is_junior', 0)
            ->orderBy('name')
            ->get();

        // グローブ（子供）
        $glove_plans_child = RentalMenu::where('is_active', true)
            ->when($gloveCategoryId, fn($q) => $q->where('rental_menu_category_id', $gloveCategoryId))
            ->where('is_junior', 1)
            ->orderBy('name')
            ->get();

        // ゴーグル（大人）
        $goggles_plans_adult = RentalMenu::where('is_active', true)
            ->when($goggleCategoryId, fn($q) => $q->where('rental_menu_category_id', $goggleCategoryId))
            ->where('is_junior', 0)
            ->orderBy('name')
            ->get();

        // ゴーグル（子供）
        $goggles_plans_child = RentalMenu::where('is_active', true)
            ->when($goggleCategoryId, fn($q) => $q->where('rental_menu_category_id', $goggleCategoryId))
            ->where('is_junior', 1)
            ->orderBy('name')
            ->get();

        // スタンス
        $stances = collect([
            (object)['id' => 1, 'name' => 'レギュラー'],
            (object)['id' => 2, 'name' => 'グーフィー'],
        ]);

        return view('client.reservations.detail', compact(
            'header',
            'details',
            'gear_plans_adult',
            'gear_plans_child',
            'wear_plans_adult',
            'wear_plans_child',
            'glove_plans_adult',
            'glove_plans_child',
            'goggles_plans_adult',
            'goggles_plans_child',
            'stances',
            'boardCategoryId'
        ));
    }

    // 詳細（利用者情報）POST
    public function storeDetail(Request $request)
    {
        $header = session('client_reservation.header');
        if (!$header) {
            return redirect()
                ->route('client.reservation.header')
                ->with('status', '先に代表者情報を入力してください。');
        }

        $validated = $request->validate([
            'guests'                    => ['required', 'array', 'min:1'],
            'guests.*.name'             => ['required', 'string', 'max:100'],
            'guests.*.furigana'         => ['required', 'string', 'max:100'],
            'guests.*.sex'              => ['required', 'string', 'max:20'],
            'guests.*.jr'               => ['nullable', 'boolean'],
            'guests.*.tall'             => ['nullable', 'integer', 'min:0'],
            'guests.*.foot'             => ['nullable', 'numeric', 'min:0'],
            'guests.*.stance_id'        => ['nullable', 'integer'],
            'guests.*.gear_plan_id'     => ['nullable', 'exists:rental_menus,id'],
            'guests.*.wear_plan_id'     => ['nullable', 'exists:rental_menus,id'],
            'guests.*.wear_size'        => ['nullable', 'string', 'max:50'],
            'guests.*.glove_plan_id'    => ['nullable', 'exists:rental_menus,id'],
            'guests.*.glove_size'       => ['nullable', 'string', 'max:50'],
            'guests.*.goggles_plan_id'  => ['nullable', 'exists:rental_menus,id'],
            'guests.*.helmet'           => ['nullable', 'boolean'],
            'guests.*.is_step_on'       => ['nullable', 'boolean'],
            'guests.*.comment'          => ['nullable', 'string', 'max:1000'],
        ]);

        // セッション保存用に整形
        $normalizedDetails = [];
        foreach ($validated['guests'] as $i => $guest) {
            $normalizedDetails[] = [
                'name'            => $guest['name'] ?? '',
                'furigana'        => $guest['furigana'] ?? '',
                'sex'             => $guest['sex'] ?? '',
                'jr'              => !empty($guest['jr']),
                'tall'            => $guest['tall'] ?? null,
                'foot'            => $guest['foot'] ?? null,
                'stance_id'       => $guest['stance_id'] ?? null,
                'gear_plan_id'    => $guest['gear_plan_id'] ?? null,
                'wear_plan_id'    => $guest['wear_plan_id'] ?? null,
                'wear_size'       => $guest['wear_size'] ?? null,
                'glove_plan_id'   => $guest['glove_plan_id'] ?? null,
                'glove_size'      => $guest['glove_size'] ?? null,
                'goggles_plan_id' => $guest['goggles_plan_id'] ?? null,
                'helmet'          => !empty($guest['helmet']),
                'is_step_on'      => !empty($guest['is_step_on']),
                'comment'         => $guest['comment'] ?? '',
            ];
        }

        // 「利用者を追加」ボタンが押された場合は、既存データに追加してdetail画面に戻る
        if ($request->input('action') === 'add_guest') {
            // 既存のセッションデータを取得
            $existingDetails = session('client_reservation.details', []);

            // 新しい利用者情報を既存データに追加
            $allDetails = array_merge($existingDetails, $normalizedDetails);

            session(['client_reservation.details' => $allDetails]);

            return redirect()
                ->route('client.reservation.detail')
                ->with('status', '利用者情報を保存しました。続けて利用者を追加してください。');
        }

        // 「確認画面へ」ボタンが押された場合
        $editingIndex = session('client_reservation.editing_index');

        if ($editingIndex !== null && count($validated['guests']) === 1) {
            // 単一利用者の編集モード：該当インデックスのみ更新
            $existingDetails = session('client_reservation.details', []);
            $existingDetails[$editingIndex] = $normalizedDetails[0];
            session(['client_reservation.details' => $existingDetails]);
            session()->forget('client_reservation.editing_index');
        } elseif (count($validated['guests']) > 1 || $request->query('edit') === 'all') {
            // 編集モードまたは複数利用者の一括入力：上書き保存
            session(['client_reservation.details' => $normalizedDetails]);
            session()->forget('client_reservation.editing_index');
        } else {
            // 新規追加モード：既存データと統合
            $existingDetails = session('client_reservation.details', []);
            $allDetails = array_merge($existingDetails, $normalizedDetails);
            session(['client_reservation.details' => $allDetails]);
        }

        return redirect()
            ->route('client.reservation.confirm')
            ->with('status', '利用者情報を一時保存しました。内容を確認してください。');
    }

    // 確認画面
    public function confirm()
    {
        $header = session('client_reservation.header');
        $details = session('client_reservation.details');

        if (!$header || !$details) {
            return redirect()
                ->route('client.reservation.header')
                ->with('status', '先に代表者情報と利用者情報を入力してください。');
        }

        $resort = Resort::find($header['resort_id']);

        // メニュー名を取得
        $details_with_names = collect($details)->map(function ($detail) {
            $detail['gear_plan_name'] = $detail['gear_plan_id']
                ? (RentalMenu::find($detail['gear_plan_id'])->name ?? '利用しない')
                : '利用しない';
            $detail['wear_plan_name'] = $detail['wear_plan_id']
                ? (RentalMenu::find($detail['wear_plan_id'])->name ?? '利用しない')
                : '利用しない';
            $detail['glove_plan_name'] = $detail['glove_plan_id']
                ? (RentalMenu::find($detail['glove_plan_id'])->name ?? '利用しない')
                : '利用しない';
            $detail['goggles_plan_name'] = $detail['goggles_plan_id']
                ? (RentalMenu::find($detail['goggles_plan_id'])->name ?? '利用しない')
                : '利用しない';
            $detail['stance_name'] = $detail['stance_id']
                ? (['1' => 'レギュラー', '2' => 'グーフィー'][$detail['stance_id']] ?? '')
                : '';
            return $detail;
        })->toArray();

        return view('client.reservations.confirm', [
            'header' => $header,
            'details' => $details_with_names,
            'resort' => $resort,
        ]);
    }

    // DB保存
    public function store(Request $request)
    {
        $header = session('client_reservation.header');
        $details = session('client_reservation.details');

        if (!$header || !$details) {
            return redirect()
                ->route('client.reservation.header')
                ->with('status', 'セッションが切れました。お手数ですが、最初から入力し直してください。');
        }

        DB::beginTransaction();

        try {

            // ▼▼▼ 追加：来店日ごとの連番(build_number)を算出 ▼▼▼
            // 排他制御(lockForUpdate)を行い、同時アクセスの重複を防ぎつつ最大値を取得
            $currentMax = Reservation::withTrashed()
                ->where('visit_date', $header['reserve_date'])
                ->lockForUpdate()
                ->max('build_number');

            // 最大値があれば+1、なければ1番とする
            $nextBuildNumber = $currentMax ? $currentMax + 1 : 1;
            // ▲▲▲ 追加ここまで ▲▲▲


            $token = (string)Str::uuid();

            // 予約ヘッダ登録
            $reservation = Reservation::create([
                'rep_last_name'         => $header['last_name'],
                'rep_first_name'        => $header['first_name'],
                'rep_last_name_kana'    => $header['last_name_f'],
                'rep_first_name_kana'   => $header['first_name_f'],
                'phone'                 => $header['tel'],
                'email'                 => $header['email'],
                'visit_date'            => $header['reserve_date'],
                'visit_time'            => $header['reserve_time'],
                'return_date'           => $header['return_date'],
                'is_last_night_nighter' => false,
                'resort_id'             => $header['resort_id'],
                'note'                  => $header['comment'] ?? '',
                'is_terms_accepted'     => true,
                'token'                 => $token,
                'build_number'          => $nextBuildNumber,
                'assembly_seq'          => null,
                'printed_user_id'       => null,
                'printed_at'            => null,
                'created_by'            => null,
                'updated_by'            => null,
            ]);

            // 利用者詳細登録
            foreach ($details as $index => $guest) {
                ReservationDetail::create([
                    'reservation_id'    => $reservation->id,
                    'guest_name'        => $guest['name'],
                    'guest_name_kana'   => $guest['furigana'],
                    'gender'            => $guest['sex'],
                    'is_child'          => $guest['jr'],
                    'height'            => $guest['tall'],
                    'foot_size'         => $guest['foot'],
                    'stance'            => $guest['stance_id'] ? (['1' => 'レギュラー', '2' => 'グーフィー'][$guest['stance_id']] ?? null) : null,
                    'main_gear_menu_id' => $guest['gear_plan_id'],
                    'wear_menu_id'      => $guest['wear_plan_id'],
                    'wear_size'         => $guest['wear_size'],
                    'glove_menu_id'     => $guest['glove_plan_id'],
                    'glove_size'        => $guest['glove_size'],
                    'goggle_menu_id'    => $guest['goggles_plan_id'],
                    'is_helmet_used'    => $guest['helmet'],
                    'is_step_on'        => $guest['is_step_on'] ?? false,
                    'note'              => $guest['comment'] ?? '',
                    'group_seq'         => $index + 1,
                    'created_by'        => null,
                    'updated_by'        => null,
                ]);
            }

            DB::commit();

            Mail::to($reservation->email)->send(new ReservationCompleted($reservation));

            // セッションクリア
            session()->forget('client_reservation.header');
            session()->forget('client_reservation.details');
            session()->forget('client_reservation.agreed');

            return redirect()
                ->route('client.reservation.success')
                ->with('status', '予約を登録しました。');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return redirect()
                ->route('client.reservation.error')
                ->with('error', '予約の登録中にエラーが発生しました。');
        }
    }

    // 完了画面
    public function success()
    {
        return view('client.reservations.success');
    }

    // エラー画面
    public function error()
    {
        return view('client.reservations.error');
    }

    // 代表者情報修正（確認画面から）
    public function editHeader()
    {
        $header = session('client_reservation.header');
        if (!$header) {
            return redirect()->route('client.reservation.header');
        }

        return redirect()->route('client.reservation.header');
    }

    // 利用者情報修正（確認画面から）
    public function editDetail(Request $request)
    {
        $details = session('client_reservation.details');
        if (!$details) {
            return redirect()->route('client.reservation.detail');
        }

        // 編集対象のインデックスを取得
        $index = $request->query('index');

        if ($index !== null && isset($details[$index])) {
            // 特定の利用者を編集モードで詳細画面に遷移
            return redirect()->route('client.reservation.detail', ['edit' => 'single', 'index' => $index]);
        }

        // インデックスが指定されていない場合は全利用者情報を表示
        return redirect()->route('client.reservation.detail', ['edit' => 'all']);
    }
}
