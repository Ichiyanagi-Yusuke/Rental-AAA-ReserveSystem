<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\ReservationDetail;
use App\Models\RentalMenu; // 必要に応じて
use App\Models\Resort;
use App\Models\RentalMenuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientReservationEditController extends Controller
{
    /**
     * 1. 本人確認画面表示
     */
    public function showAuth($token)
    {
        return view('client.reservations.edit.auth', compact('token'));
    }

    /**
     * 1-2. 本人確認処理
     */
    public function verifyAuth(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'visit_date' => 'required|date',
        ]);

        // トークン、電話番号、メール、利用日で照合
        $reservation = Reservation::where('token', $request->token)
            ->where('phone', $request->phone)
            ->where('email', $request->email)
            ->whereDate('visit_date', $request->visit_date)
            ->first();

        if (! $reservation) {
            // エラー画面へ遷移（あるいはwithErrorsで戻す）
            // ここでは要件通り「本人確認が取れませんでした」のエラー画面へ（viewは適宜作成、今回はbackでエラー表示させる例とします）
            return back()->withErrors(['auth_failed' => '本人確認が取れませんでした。入力内容を確認してください。']);
        }

        // セッションに編集中の予約IDを保存
        session(['editing_reservation_id' => $reservation->id]);

        return redirect()->route('client.reservation.edit.menu');
    }

    /**
     * 2. 修正内容選択画面（メニュー）
     */
    public function menu()
    {
        $reservationId = session('editing_reservation_id');
        if (! $reservationId) return redirect()->route('client.reservation.error'); // 適切なエラーへ

        $reservation = Reservation::with('details')->findOrFail($reservationId);

        return view('client.reservations.edit.menu', compact('reservation'));
    }


    /**
     * 3. 代表者情報の編集画面
     */
    public function editHeader()
    {
        $reservationId = session('editing_reservation_id');
        if (! $reservationId) return redirect()->route('client.reservation.error');

        $reservation = Reservation::findOrFail($reservationId);

        // ★追加: ゲレンデ選択肢を取得
        $resorts = Resort::orderBy('id', 'asc')->get();

        return view('client.reservations.edit.header', compact('reservation', 'resorts'));
    }

    /**
     * 3-2. 代表者情報の更新処理
     */
    public function updateHeader(Request $request)
    {
        $reservationId = session('editing_reservation_id');
        if (! $reservationId) return redirect()->route('client.reservation.error');

        // ★修正: 全項目のバリデーションを追加
        // フォームの name 属性はモデルのカラム名に合わせています
        $request->validate([
            'rep_last_name'       => 'required|string|max:50',
            'rep_first_name'      => 'required|string|max:50',
            'rep_last_name_kana'  => 'required|string|max:50',
            'rep_first_name_kana' => 'required|string|max:50',
            'phone'               => 'required|string|max:20',
            'email'               => 'required|email|max:255',
            'visit_date'          => 'required|date',
            'visit_time'          => 'required', // H:i 形式
            'return_date'         => 'required|date|after_or_equal:visit_date',
            'resort_id'           => 'required|exists:resorts,id',
            'note'                => 'nullable|string',
        ]);

        $reservation = Reservation::findOrFail($reservationId);
        $reservation->fill($request->all());

        $reservation->save();

        return redirect()->route('client.reservation.edit.menu')->with('status', '代表者情報を更新しました。');
    }

    /**
     * 4. 利用者情報の編集画面
     */
    public function editDetail($detailId)
    {
        $reservationId = session('editing_reservation_id');
        if (! $reservationId) return redirect()->route('client.reservation.error');

        $detail = ReservationDetail::where('reservation_id', $reservationId)
            ->where('id', $detailId)
            ->firstOrFail();

        // ★追加: マスタデータの取得 (ClientReservationControllerと同様のロジック)
        $categoryMap = RentalMenuCategory::whereIn('name', ['スノーボード', 'スキー', 'ウェア', 'グローブ', 'ゴーグル'])
            ->where('is_active', true)
            ->pluck('id', 'name');

        $boardCategoryId = $categoryMap['スノーボード'] ?? null;
        $skiCategoryId = $categoryMap['スキー'] ?? null;
        $wearCategoryId = $categoryMap['ウェア'] ?? null;
        $gloveCategoryId = $categoryMap['グローブ'] ?? null;
        $goggleCategoryId = $categoryMap['ゴーグル'] ?? null;

        $mainCategoryIds = array_filter([$boardCategoryId, $skiCategoryId]);

        // 各種メニュー取得
        $getMenus = function ($catId, $isJunior) use ($mainCategoryIds) {
            $query = RentalMenu::where('is_active', true);
            if (is_array($catId)) {
                $query->whereIn('rental_menu_category_id', $catId)->where('menu_type', 'base');
            } else {
                $query->where('rental_menu_category_id', $catId);
            }
            return $query->where('is_junior', $isJunior)->orderBy('name')->get();
        };

        $gear_plans_adult = $getMenus($mainCategoryIds, 0);
        $gear_plans_child = $getMenus($mainCategoryIds, 1);

        $wear_plans_adult = $getMenus($wearCategoryId, 0);
        $wear_plans_child = $getMenus($wearCategoryId, 1);

        $glove_plans_adult = $getMenus($gloveCategoryId, 0);
        $glove_plans_child = $getMenus($gloveCategoryId, 1);

        $goggles_plans_adult = $getMenus($goggleCategoryId, 0);
        $goggles_plans_child = $getMenus($goggleCategoryId, 1);

        return view('client.reservations.edit.detail', compact(
            'detail',
            'gear_plans_adult',
            'gear_plans_child',
            'wear_plans_adult',
            'wear_plans_child',
            'glove_plans_adult',
            'glove_plans_child',
            'goggles_plans_adult',
            'goggles_plans_child',
            'boardCategoryId'
        ));
    }

    /**
     * 4-2. 利用者情報の更新処理
     */
    public function updateDetail(Request $request, $detailId)
    {
        $reservationId = session('editing_reservation_id');
        if (! $reservationId) return redirect()->route('client.reservation.error');

        $detail = ReservationDetail::where('reservation_id', $reservationId)
            ->where('id', $detailId)
            ->firstOrFail();

        // バリデーション (DBカラム名に合わせています)
        $request->validate([
            'guest_name'        => 'required|string|max:100',
            'guest_name_kana'   => 'required|string|max:100',
            'gender'            => 'required|string',
            'is_child'          => 'nullable|boolean',
            'height'            => 'nullable|integer|min:0',
            'foot_size'         => 'nullable|numeric|min:0',
            'stance'            => 'nullable|string', // 文字列で受け取る
            'main_gear_menu_id' => 'nullable|exists:rental_menus,id',
            'wear_menu_id'      => 'nullable|exists:rental_menus,id',
            'wear_size'         => 'nullable|string|max:50',
            'glove_menu_id'     => 'nullable|exists:rental_menus,id',
            'glove_size'        => 'nullable|string|max:50',
            'goggle_menu_id'    => 'nullable|exists:rental_menus,id',
            'is_helmet_used'    => 'nullable|boolean',
            'is_step_on'        => 'nullable|boolean',
            'note'              => 'nullable|string|max:1000',
        ]);

        // チェックボックス未送信時の対策 (fill用にマージ)
        $data = $request->all();
        $data['is_child']       = $request->has('is_child');
        $data['is_helmet_used'] = $request->has('is_helmet_used');
        $data['is_step_on']     = $request->has('is_step_on');

        $detail->fill($data);
        $detail->save();

        return redirect()->route('client.reservation.edit.menu')
            ->with('status', $detail->guest_name . ' さんの情報を更新しました。');
    }

    /**
     * 5. 変更完了処理（メール送信・帳票クリア）
     */
    public function complete()
    {
        $reservationId = session('editing_reservation_id');
        if (! $reservationId) return redirect()->route('client.reservation.error');

        $reservation = Reservation::findOrFail($reservationId);

        // 帳票出力情報のクリア
        if ($reservation->printed_at || $reservation->printed_user_id) {
            $reservation->printed_at = null;
            $reservation->printed_user_id = null;
            $reservation->save();
        }

        // TODO: メール送信処理をここに実装
        // Mail::to($reservation->email)->send(new ReservationUpdated($reservation));

        // セッションクリア（必要に応じて）
        session()->forget('editing_reservation_id');

        return redirect()->route('client.reservation.edit.finished');
    }

    public function finished()
    {
        return view('client.reservations.edit.finished');
    }
}
