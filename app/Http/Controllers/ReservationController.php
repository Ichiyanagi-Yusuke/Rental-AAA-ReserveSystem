<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\ReservationDetail;
use App\Models\Resort;
use App\Models\RentalMenu;
use App\Models\RentalMenuCategory; // ★ 追加
use App\Models\BusinessCalendar;
use App\Models\ReservationSummary;

use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;



class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function isMasterUser(): bool
    {
        $user = Auth::user();

        return $user && in_array((int) $user->role, [0, 1], true);
    }

    // 一覧
    public function index(Request $request)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        // $query = Reservation::with('resort')
        //     ->withCount('details');

        $query = ReservationSummary::query();

        // ?filter=today / ?filter=tomorrow を解釈
        $filter      = $request->query('filter');
        // ★ 追加: 特定日付指定 (?date=2025-12-10)
        $dateParam   = $request->query('date');

        $statusParam = $request->query('status');

        

        $targetDate  = null;
        $filterLabel = null;

        if ($filter === 'today') {
            $targetDate  = Carbon::today();
            $filterLabel = '本日の予約';
        } elseif ($filter === 'tomorrow') {
            $targetDate  = Carbon::tomorrow();
            $filterLabel = '明日の予約';
        } elseif ($dateParam) {
            // ★ 追加: 日付パラメータがある場合の処理
            try {
                $targetDate = Carbon::parse($dateParam);
                $filterLabel = $targetDate->format('Y年n月j日') . 'の予約';
            } catch (\Exception $e) {
                // 不正な日付形式の場合は無視
            }
        }

        // ▼ 追加: 変更確認待ちの絞り込み処理
        if ($statusParam === 'needs_confirmation') {
            $query->where('is_needs_confirmation', true);
            // フィルタラベルを設定（画面上のタイトル用）
            $filterLabel = '変更確認待ちの予約';
        }
        // ▼▼▼ 追加: キャンセル確認待ちの絞り込み ▼▼▼
        elseif ($statusParam === 'cancelled_needs_confirmation') {
            // 論理削除されたものだけを対象にする
            $query->onlyTrashed()
                ->where('is_cancel_needs_confirmation', true);
            $filterLabel = 'キャンセル確認待ち（印刷済）';
        }
        // ★ 追加: コメント確認待ち
        elseif ($statusParam === 'comment_needs_confirmation') {
            $query->whereNotNull('note')
                ->where('note', '!=', '')
                ->where('is_comment_checked', false);
            $filterLabel = '要望コメント確認待ちの予約';
        }
        // ★ 追加: 利用者コメント確認待ちの絞り込み
        // elseif ($statusParam === 'guest_comment_needs_confirmation') {
        //     $query->whereHas('details', function ($q) {
        //         $q->whereNotNull('note')
        //             ->where('note', '!=', '')
        //             ->where('is_comment_checked', false);
        //     });
        //     $filterLabel = '利用者コメント確認待ちの予約';
        // }
        // ★ 追加: 利用者コメント確認待ちの絞り込み
        elseif ($statusParam === 'guest_comment_needs_confirmation') {
            // whereHas('details'...) は使えないため、ビューに追加したフラグを使用
            $query->where('has_guest_comment_issue', true);

            $filterLabel = '利用者コメント確認待ちの予約';
        }

        if ($targetDate) {
            $query->whereDate('visit_date', $targetDate->toDateString());
        }

        $reservations = $query
            ->orderBy('visit_date')
            ->orderBy('visit_time')
            ->paginate(20)
            ->withQueryString();

        return view('reservations.index', [
            'reservations' => $reservations,
            'filter'       => $filter,
            'filterLabel'  => $filterLabel,
            'targetDate'   => $targetDate?->toDateString(),
        ]);
    }

    // 検索フォーム表示
    public function search()
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        return view('reservations.search');
    }

    // 検索実行
    public function searchResults(Request $request)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $query = ReservationSummary::query();
        // $query = Reservation::with('resort')->withCount('details');

        // 電話番号での検索
        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        // メールアドレスでの検索
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // 代表者姓での検索
        if ($request->filled('rep_last_name')) {
            $query->where('rep_last_name', 'like', '%' . $request->rep_last_name . '%');
        }

        // 代表者名での検索
        if ($request->filled('rep_first_name')) {
            $query->where('rep_first_name', 'like', '%' . $request->rep_first_name . '%');
        }

        // 代表者姓（フリガナ）での検索
        if ($request->filled('rep_last_name_kana')) {
            $query->where('rep_last_name_kana', 'like', '%' . $request->rep_last_name_kana . '%');
        }

        // 代表者名（フリガナ）での検索
        if ($request->filled('rep_first_name_kana')) {
            $query->where('rep_first_name_kana', 'like', '%' . $request->rep_first_name_kana . '%');
        }

        // 来店日での検索
        if ($request->filled('visit_date')) {
            $query->whereDate('visit_date', $request->visit_date);
        }

        $reservations = $query
            ->orderBy('visit_date', 'desc')
            ->orderBy('visit_time', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('reservations.search', [
            'reservations' => $reservations,
            'searchParams' => $request->all(),
        ]);
    }

    // ヘッダーからの全文検索
    public function quickSearch(Request $request)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $keyword = $request->input('q');

        if (empty($keyword)) {
            return redirect()->route('reservations.index');
        }

        $query = ReservationSummary::query();

        // 検索キーワードに含まれる全角スペースを半角に変換（ヒット率向上のため）
        $keyword = str_replace('　', ' ', $keyword);

        // 複数のフィールドで検索（OR条件）
        $query->where(function ($q) use ($keyword) {
            $q->where('phone', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . $keyword . '%')
                // ▼▼▼ 修正箇所: rep_last_name等は存在しないため、rep_name等に変更 ▼▼▼
                ->orWhere('rep_name', 'like', '%' . $keyword . '%')
                ->orWhere('rep_kana', 'like', '%' . $keyword . '%')
                // ▲▲▲ 修正ここまで ▲▲▲

                // ★推奨: 予約番号でも検索できるように追加
                ->orWhere('reservation_number', 'like', '%' . $keyword . '%');
        });

        $reservations = $query
            ->orderBy('visit_date', 'desc')
            ->orderBy('visit_time', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('reservations.index', [
            'reservations' => $reservations,
            'filter'       => null,
            'filterLabel'  => '検索結果: "' . $keyword . '"',
            'targetDate'   => null,
        ]);
    }

    // 予約カレンダー表示
    public function calendar(Request $request)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        // 年月をパラメータから取得（デフォルトは今月）
        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);

        // カレンダーの基準日を作成
        $baseDate = Carbon::create($year, $month, 1);

        // 当月の開始日と終了日
        $startOfMonth = $baseDate->copy()->startOfMonth();
        $endOfMonth = $baseDate->copy()->endOfMonth();

        // 当月の予約データを取得し、日付ごとに集計
        $reservations = Reservation::whereBetween('visit_date', [$startOfMonth, $endOfMonth])
            ->withCount('details')
            ->get()
            ->groupBy(function ($reservation) {
                return $reservation->visit_date->format('Y-m-d');
            })
            ->map(function ($group) {
                return (object) [
                    'reservation_count' => $group->count(),
                    'guest_count' => $group->sum('details_count'),
                ];
            });

        // カレンダーの週を生成
        $calendar = [];
        $currentDate = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);

        while ($currentDate <= $endOfMonth->copy()->endOfWeek(Carbon::SATURDAY)) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $dateStr = $currentDate->format('Y-m-d');
                $isCurrentMonth = $currentDate->month == $month;

                $dayData = [
                    'date' => $currentDate->copy(),
                    'dateStr' => $dateStr,
                    'isCurrentMonth' => $isCurrentMonth,
                    'isToday' => $currentDate->isToday(),
                    'reservation_count' => 0,
                    'guest_count' => 0,
                ];

                if ($isCurrentMonth && isset($reservations[$dateStr])) {
                    $dayData['reservation_count'] = $reservations[$dateStr]->reservation_count;
                    $dayData['guest_count'] = $reservations[$dateStr]->guest_count ?? 0;
                }

                $week[] = $dayData;
                $currentDate->addDay();
            }
            $calendar[] = $week;
        }

        // 前月・次月のリンク用
        $prevMonth = $baseDate->copy()->subMonth();
        $nextMonth = $baseDate->copy()->addMonth();

        // 年月選択用のオプション
        $yearOptions = range(Carbon::now()->year - 2, Carbon::now()->year + 2);
        $monthOptions = range(1, 12);

        return view('reservations.calendar', [
            'calendar' => $calendar,
            'currentYear' => $year,
            'currentMonth' => $month,
            'baseDate' => $baseDate,
            'prevMonth' => $prevMonth,
            'nextMonth' => $nextMonth,
            'yearOptions' => $yearOptions,
            'monthOptions' => $monthOptions,
        ]);
    }


    public function startCreate()
    {
        // ★ 新規予約開始なので、前回の入力内容をクリア
        session()->forget('reservation.header');
        session()->forget('reservation.details');

        return redirect()->route('reservations.create.header');
    }

    // ステップ1：ヘッダー入力表示
    public function createHeader()
    {

        if (! $this->isMasterUser()) {
            abort(403);
        }

        // 一旦は全リゾートを表示
        $resorts = Resort::orderBy('id','asc')->get();

        // 途中まで入力してセッションに残っている値があれば取り出す
        $header = session('reservation.header', []);

        return view('reservations.create_header', compact('resorts', 'header'));
    }

    // ステップ1：ヘッダー入力POST
    public function storeHeader(Request $request)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $validated = $request->validate([
            'rep_last_name'        => ['required', 'string', 'max:50'],
            'rep_first_name'       => ['required', 'string', 'max:50'],
            'rep_last_name_kana'   => ['required', 'string', 'max:50'],
            'rep_first_name_kana'  => ['required', 'string', 'max:50'],
            'phone'                => ['required', 'string', 'max:20'],
            'email'                => ['required', 'email', 'max:255'],
            'visit_date'           => ['required', 'date', 'after_or_equal:today'],
            'visit_time'           => ['required', 'date_format:H:i'],
            'return_date'          => ['required', 'date', 'after_or_equal:visit_date'],
            'is_last_day_night'    => ['nullable', 'boolean'],
            'resort_id'            => ['required', 'exists:resorts,id'],
            'note'                 => ['nullable', 'string'],
            'is_terms_agreed'      => ['required', 'accepted'], // 社内でも念のためチェック

        ]);

        // checkbox boolean 補正
        $validated['is_last_day_night'] = $request->boolean('is_last_day_night');
        $validated['is_terms_agreed']   = $request->has('is_terms_agreed');

        // セッションに保存
        session(['reservation.header' => $validated]);

        // 営業カレンダーから、その日のパターンを取得
        $calendar = BusinessCalendar::whereDate('date', $request->visit_date)->first();
        

        // パターン未設定 or 休業日の場合はエラー
        if (! $calendar || ! $calendar->pattern || ! $calendar->pattern->is_open) {
            throw ValidationException::withMessages([
                'visit_date' => 'この日は営業していないため、予約を受け付けていません。',
            ]);
        }

        $pattern = $calendar->pattern;
        // dd($pattern->open_time);
        
        // パターンの営業時間（例: open_time / close_time カラム）
        $openTime  = Carbon::createFromFormat('H:i:s', $pattern->open_time);
        // $openTime  = $pattern->open_time;
        $closeTime = Carbon::createFromFormat('H:i:s', $pattern->close_time); // 受付終了時刻のカラム名に合わせる
        // $closeTime = $pattern->close_time; // 受付終了時刻のカラム名に合わせる
        $rVisitTime = Carbon::createFromFormat('H:i',$request->visit_time);
        // dd($openTime);
        // 営業時間外ならエラー
        if ($rVisitTime->lt($openTime) || $rVisitTime->gt($closeTime)) {
            throw ValidationException::withMessages([
                'visit_time' => '来店予定時刻は営業時間内（' . $openTime->format('H:i') . '〜' . $closeTime->format('H:i') . '）で入力してください。',
            ]);
        }
            

        // 来店日を日付として正規化（時刻は無視）
        $visitDate = Carbon::parse($validated['visit_date'])->toDateString();
        $phone     = $validated['phone'];

        // ★ すでに同じ電話番号＆来店日の予約があるかチェック
        $exists = Reservation::where('phone', $phone)
            ->whereDate('visit_date', $visitDate)
            ->exists(); // SoftDeletes を使っていれば自動で deleted_at は除外されます

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'phone' => 'この電話番号と来店日で既に予約が登録されています。',
                ]);
        }

        // セッションに保存する値を整形（visit_date は正規化したものを入れておく）
        $validated['visit_date']  = $visitDate;
        $validated['is_night_use'] = !empty($validated['is_night_use']);
        $validated['is_accepted']  = !empty($validated['is_accepted']);

        return redirect()
            ->route('reservations.create.details')
            ->with('status', '代表者情報を保存しました。利用者情報を入力してください。');
    }

    // ステップ2：詳細入力表示（利用者複数）
    public function createDetails(Request $request)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        // 代表者が入っていない場合はヘッダーから
        $header = session('reservation.header');
        if (! $header) {
            return redirect()
                ->route('reservations.create.header')
                ->with('status', '先に代表者情報を入力してください。');
        }
        
        
        // --- ① セッションに保存済みの利用者情報を取得 -------------------
        $sessionDetails = session('reservation.details', []);
        
        // --- ② バリデーションエラーで戻ってきた場合は old('guests') を優先 --
        $details = $request->old('guests', $sessionDetails);
        
        
        // --- ③ どちらも空なら 1 行分だけ空データを用意 -------------------
        if (empty($details)) {
            $details = [[
                'guest_name'          => '',
                'guest_name_kana'     => '',
                'gender'              => '',
                'is_child'            => false,
                'height'              => null,
                'foot_size'           => null,
                'stance'              => '',
                'main_gear_menu_id'   => '',
                'wear_menu_id'        => '',
                'wear_size'           => '',
                'glove_menu_id'       => '',
                'glove_size'          => '',
                'goggle_menu_id'      => '',
                'is_helmet_used'      => false,
                'is_step_on'          => false,
                'note'                => '',
                'group_seq'           => 1,
                ]];
            }
            
            // dd($details);
        // ★ ここでログ or dd すると「読み出した details」が見れます
        // dd($details);

        // --- ④ プルダウン用のメニュー取得（今までのロジックそのまま） ----

        $categoryMap = RentalMenuCategory::whereIn('name', ['スノーボード', 'スキー', 'ウェア', 'グローブ', 'ゴーグル'])
            ->where('is_active', true)
            ->pluck('id', 'name');

        $boardCategoryId   = $categoryMap['スノーボード'] ?? null;
        $skiCategoryId     = $categoryMap['スキー'] ?? null;
        $wearCategoryId    = $categoryMap['ウェア'] ?? null;
        $gloveCategoryId   = $categoryMap['グローブ'] ?? null;
        $goggleCategoryId  = $categoryMap['ゴーグル'] ?? null;

        $mainCategoryIds = array_filter([$boardCategoryId, $skiCategoryId]);

        // メインギアプラン（大人）: is_junior = 0 ＋ base メニューのみ
        $mainMenusAdult = RentalMenu::where('is_active', true)
            ->where('menu_type', 'base') // ★ 追加
            ->when($mainCategoryIds, fn($q) => $q->whereIn('rental_menu_category_id', $mainCategoryIds))
            ->where('is_junior', 0)
            ->orderBy('name')
            ->get();

        // メインギアプラン（Jr）: is_junior = 1 ＋ base メニューのみ
        $mainMenusChild = RentalMenu::where('is_active', true)
            ->where('menu_type', 'base') // ★ 追加
            ->when($mainCategoryIds, fn($q) => $q->whereIn('rental_menu_category_id', $mainCategoryIds))
            ->where('is_junior', 1)
            ->orderBy('name')
            ->get();

        // ウェア（大人）
        $wearMenusAdult = RentalMenu::where('is_active', true)
            ->when($wearCategoryId, fn($q) => $q->where('rental_menu_category_id', $wearCategoryId))
            ->where('is_junior', 0)
            ->orderBy('name')
            ->get();

        // ウェア（Jr）
        $wearMenusChild = RentalMenu::where('is_active', true)
            ->when($wearCategoryId, fn($q) => $q->where('rental_menu_category_id', $wearCategoryId))
            ->where('is_junior', 1)
            ->orderBy('name')
            ->get();

        // グローブ（大人）
        $gloveMenusAdult = RentalMenu::where('is_active', true)
            ->when($gloveCategoryId, fn($q) => $q->where('rental_menu_category_id', $gloveCategoryId))
            ->where('is_junior', 0)
            ->orderBy('name')
            ->get();

        // グローブ（Jr）
        $gloveMenusChild = RentalMenu::where('is_active', true)
            ->when($gloveCategoryId, fn($q) => $q->where('rental_menu_category_id', $gloveCategoryId))
            ->where('is_junior', 1)
            ->orderBy('name')
            ->get();

        // ゴーグル（大人）
        $goggleMenusAdult = RentalMenu::where('is_active', true)
            ->when($goggleCategoryId, fn($q) => $q->where('rental_menu_category_id', $goggleCategoryId))
            ->where('is_junior', 0)
            ->orderBy('name')
            ->get();

        // ゴーグル（Jr）
        $goggleMenusChild = RentalMenu::where('is_active', true)
            ->when($goggleCategoryId, fn($q) => $q->where('rental_menu_category_id', $goggleCategoryId))
            ->where('is_junior', 1)
            ->orderBy('name')
            ->get();

        return view('reservations.create_details', compact(
            'header',
            'details',
            'mainMenusAdult',
            'mainMenusChild',
            'wearMenusAdult',
            'wearMenusChild',
            'gloveMenusAdult',
            'gloveMenusChild',
            'goggleMenusAdult',
            'goggleMenusChild',
            'boardCategoryId',
        ));
    }


    // ステップ2：詳細入力POST
    public function storeDetails(Request $request)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $header = session('reservation.header');
        if (! $header) {
            return redirect()
                ->route('reservations.create.header')
                ->with('status', '先に代表者情報を入力してください。');
        }

        // --- バリデーション -----------------------------------------
        $validated = $request->validate([
            'guests'                        => ['required', 'array', 'min:1'],

            'guests.*.guest_name'           => ['required', 'string', 'max:100'],
            'guests.*.guest_name_kana'      => ['required', 'string', 'max:100'],
            'guests.*.gender'               => ['required', 'string', 'max:20'],
            'guests.*.is_child'             => ['nullable', 'boolean'],

            'guests.*.height'               => ['nullable', 'integer', 'min:0'],
            'guests.*.foot_size'            => ['nullable', 'numeric', 'min:0'],

            'guests.*.stance'               => ['nullable', 'string', 'max:50'],

            'guests.*.main_gear_menu_id'    => ['nullable', 'exists:rental_menus,id'],
            'guests.*.wear_menu_id'         => ['nullable', 'exists:rental_menus,id'],
            'guests.*.wear_size'            => ['nullable', 'string', 'max:50'],
            'guests.*.glove_menu_id'        => ['nullable', 'exists:rental_menus,id'],
            'guests.*.glove_size'           => ['nullable', 'string', 'max:50'],
            'guests.*.goggle_menu_id'       => ['nullable', 'exists:rental_menus,id'],

            'guests.*.is_helmet_used'       => ['nullable', 'boolean'],
            'guests.*.is_step_on'           => ['nullable', 'boolean'],

            'guests.*.note'                 => ['nullable', 'string', 'max:1000'],
        ]);

        // --- セッション保存用に形を整える ----------------------------
        $normalizedDetails = [];
        foreach ($validated['guests'] as $i => $guest) {
            $normalizedDetails[] = [
                'guest_name'          => $guest['guest_name'] ?? '',
                'guest_name_kana'     => $guest['guest_name_kana'] ?? '',
                'gender'              => $guest['gender'] ?? '',
                'is_child'            => ! empty($guest['is_child']),
                'height'              => $guest['height'] ?? null,
                'foot_size'           => $guest['foot_size'] ?? null,
                'stance'              => $guest['stance'] ?? null,

                'main_gear_menu_id'   => $guest['main_gear_menu_id'] ?? null,
                'wear_menu_id'        => $guest['wear_menu_id'] ?? null,
                'wear_size'           => $guest['wear_size'] ?? null,
                'glove_menu_id'       => $guest['glove_menu_id'] ?? null,
                'glove_size'          => $guest['glove_size'] ?? null,
                'goggle_menu_id'      => $guest['goggle_menu_id'] ?? null,

                'is_helmet_used'      => ! empty($guest['is_helmet_used']),
                'is_step_on'          => ! empty($guest['is_step_on']),

                'note'                => $guest['note'] ?? '',
                'group_seq'           => $i + 1,
            ];
        }

        // ★ ここでセッションに保存（createDetails から読み出す元ネタ）
        session([
            'reservation.details' => $normalizedDetails,
        ]);

        // ★ ここで一旦中身を確認してみてください（確認終わったらコメントアウト）
        // dd(session('reservation.details'));
        // \Log::info('DETAILS_SAVED', ['details' => session('reservation.details')]);

        // 確認画面へ
        return redirect()
            ->route('reservations.confirm')
            ->with('status', '利用者情報を一時保存しました。内容を確認してください。');
    }


    // ステップ3：確認画面
    public function confirm()
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $header  = session('reservation.header');
        $details = session('reservation.details');

        if (! $header || ! $details) {
            return redirect()
                ->route('reservations.create.header')
                ->with('status', '先に代表者情報と利用者情報を入力してください。');
        }

        // リゾート名を表示したい場合
        $resort = null;
        if (! empty($header['resort_id'])) {
            $resort = Resort::find($header['resort_id']);
        }

        return view('reservations.confirm', compact('header', 'details', 'resort'));
    }


    public function store(Request $request)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $header  = session('reservation.header');
        $details = session('reservation.details');

        if (! $header || ! $details) {
            return redirect()
                ->route('reservations.create.header')
                ->with('status', 'セッションが切れました。お手数ですが、最初から入力し直してください。');
        }

        DB::beginTransaction();

        try {
            $userId = Auth::id();
            $token  = $header['token'] ?? (string) Str::uuid();

            // ★ 代表者名などは rep_* カラムにマッピング
            $reservation = Reservation::create([
                'rep_last_name'       => $header['rep_last_name']       // form が rep_last_name の場合
                    ?? $header['last_name']      // form が last_name の場合
                    ?? '',
                'rep_first_name'      => $header['rep_first_name']
                    ?? $header['first_name']
                    ?? '',
                'rep_last_name_kana'  => $header['rep_last_name_kana']
                    ?? $header['last_name_kana']
                    ?? '',
                'rep_first_name_kana' => $header['rep_first_name_kana']
                    ?? $header['first_name_kana']
                    ?? '',

                'phone'               => $header['phone']  ?? '',
                'email'               => $header['email']  ?? '',

                'visit_date'          => $header['visit_date'] ?? null,
                'visit_time'          => $header['visit_time'] ?? null,
                'return_date'         => $header['return_date'] ?? null,

                'is_last_night_nighter' => ! empty($header['is_last_night_nighter']),
                'resort_id'             => $header['resort_id'] ?? null,
                'note'                  => $header['note'] ?? '',

                // 同意フラグのカラム名が is_terms_accepted / is_agreement_accepted どちらかの場合を想定
                'is_terms_accepted'     => $header['is_terms_accepted']
                    ?? $header['is_agreement_accepted']
                    ?? false,

                'token'             => $token,
                'assembly_seq'      => null,
                'printed_user_id'   => null,
                'printed_at'        => null,
                'created_by'        => $userId,
                'updated_by'        => $userId,
            ]);

            // ★ 詳細側は前回のままでOK（念のため略）
            foreach ($details as $index => $guest) {
                ReservationDetail::create([
                    'reservation_id'        => $reservation->id,
                    'guest_name'            => $guest['guest_name'] ?? '',
                    'guest_name_kana'       => $guest['guest_name_kana'] ?? '',
                    'gender'                => $guest['gender'] ?? '',
                    'is_child'              => ! empty($guest['is_child']),
                    'height'                => $guest['height'] ?? null,
                    'foot_size'             => $guest['foot_size'] ?? null,
                    'stance'                => $guest['stance'] ?? null,
                    'main_gear_menu_id'     => $guest['main_gear_menu_id'] ?? null,
                    'wear_menu_id'          => $guest['wear_menu_id'] ?? null,
                    'wear_size'             => $guest['wear_size'] ?? null,
                    'glove_menu_id'         => $guest['glove_menu_id'] ?? null,
                    'glove_size'            => $guest['glove_size'] ?? null,
                    'goggle_menu_id'        => $guest['goggle_menu_id'] ?? null,
                    'is_helmet_used'        => ! empty($guest['is_helmet_used']),
                    'is_step_on'            => ! empty($guest['is_step_on']),
                    'note'                  => $guest['note'] ?? '',
                    'group_seq'             => $guest['group_seq'] ?? ($index + 1),
                    'created_by'            => $userId,
                    'updated_by'            => $userId,
                ]);
            }

            DB::commit();

            session()->forget('reservation.header');
            session()->forget('reservation.details');

            return redirect()
                ->route('reservations.index')
                ->with('status', '予約を登録しました。');
        } catch (\Throwable $e) {
            DB::rollBack();
            // 開発中は一旦これで中身を見るのもアリ
            throw $e;

            report($e);

            return redirect()
                ->route('reservations.create.details')
                ->with('status', '予約の登録中にエラーが発生しました。もう一度お試しください。');
        }
    }


    // 完了：DB 保存
    public function complete(Request $request)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $header  = session('reservation.header');
        $details = session('reservation.details', []);

        if (! $header || empty($details)) {
            return redirect()->route('reservations.create.header')
                ->with('status', '予約情報が不足しています。再度入力してください。');
        }

        
        DB::transaction(function () use ($header, $details) {
            $userId = Auth::id();
            
            $currentMax = Reservation::withTrashed()
                ->where('visit_date', $header['reserve_date'])
                ->lockForUpdate()
                ->max('build_number');
    
            // 最大値があれば+1、なければ1番とする
            $nextBuildNumber = $currentMax ? $currentMax + 1 : 1;

            $token = (string)Str::uuid();
            
            // 予約ヘッダ登録
            $reservation = Reservation::create([
                'rep_last_name'        => $header['rep_last_name'],
                'rep_first_name'       => $header['rep_first_name'],
                'rep_last_name_kana'   => $header['rep_last_name_kana'],
                'rep_first_name_kana'  => $header['rep_first_name_kana'],
                'phone'                => $header['phone'],
                'email'                => $header['email'],
                'visit_date'           => $header['visit_date'],
                'visit_time'           => $header['visit_time'],
                'return_date'          => $header['return_date'],
                'is_last_day_night'    => $header['is_last_day_night'] ?? false,
                'resort_id'            => $header['resort_id'],
                'note'                 => $header['note'] ?? null,
                'is_terms_agreed'      => $header['is_terms_agreed'] ?? false,
                // token はモデル側のbootで自動採番
                'build_number'         => $nextBuildNumber,
                'printed_user_id'      => null,
                'created_by'           => $userId,
                'updated_by'           => $userId,
            ]);

            // 利用者詳細登録
            foreach ($details as $index => $guest) {
                ReservationDetail::create([
                    'reservation_id'       => $reservation->id,
                    'guest_name'           => $guest['guest_name'],
                    'guest_name_kana'      => $guest['guest_name_kana'],
                    'gender'               => $guest['gender'],
                    'is_child'             => $guest['is_child'] ?? false,
                    'height'               => $guest['height'] ?? null,
                    'foot_size'            => $guest['foot_size'] ?? null,
                    'stance'               => $guest['stance'] ?? null,
                    'main_gear_menu_id'    => $guest['main_gear_menu_id'] ?? null,
                    'wear_menu_id'         => $guest['wear_menu_id'] ?? null,
                    'wear_size'            => $guest['wear_size'] ?? null,
                    'glove_menu_id'        => $guest['glove_menu_id'] ?? null,
                    'glove_size'           => $guest['glove_size'] ?? null,
                    'goggle_menu_id'       => $guest['goggle_menu_id'] ?? null,
                    'is_helmet_used'       => $guest['is_helmet_used'] ?? false,
                    'note'                 => $guest['note'] ?? null,
                    'group_sequence'       => $index + 1,
                    'created_by'           => $userId,
                    'updated_by'           => $userId,
                ]);
            }
        });

        // セッションの一時データを削除
        session()->forget(['reservation.header', 'reservation.details']);

        return redirect()
            ->route('reservations.index')
            ->with('status', '予約を登録しました。');
    }

    public function show(Reservation $reservation)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        // リレーションをまとめてロード（ネストしたリレーションを追加）
        $reservation->load([
            'resort',
            'details.mainGearMenu', // ★追加
            'details.wearMenu',     // ★追加
            'details.gloveMenu',    // ★追加
            'details.goggleMenu',   // ★追加
            'details' => function ($q) {
                $q->orderBy('id');
            },
        ]);

        return view('reservations.show', [
            'reservation' => $reservation,
            'details'     => $reservation->details,
        ]);
    }

    public function downloadPdf(Reservation $reservation)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        // 必要な情報をロード
        $reservation->load([
            'resort',
            'details' => function ($q) {
                $q->orderBy('id');
            },
        ]);

        // ★ 印刷記録（常に更新 or 初回のみ、好みですがここでは毎回更新）
        $reservation->printed_at      = now();
        $reservation->printed_user_id = Auth::id();
        $reservation->is_needs_confirmation = false; // ★追加
        $reservation->save();

        $pdf = Pdf::loadView('reservations.bill_for_reserve', [
            'reservation' => $reservation,
            'details'     => $reservation->details,
        ])
            ->setPaper('A4', 'portrait'); // A4縦

        $fileName = 'reservation_'
            . ($reservation->id ?? 'unknown')
            . '_'
            . (optional($reservation->visit_date)->format('Ymd') ?? 'date')
            . '.pdf';

        return $pdf->download($fileName);
        // ブラウザ表示にしたいときは ->stream($fileName);
    }

    public function printForm(Request $request)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        return view('reservations.print_form');
    }

    /**
     * 条件に基づき未印刷予約をまとめてPDF化し、printed_at / printed_user_id を更新
     */
    public function printExecute(Request $request)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $validated = $request->validate([
            'mode'       => ['required', 'in:today,tomorrow,range,all_unprinted'],
            'from_date'  => ['nullable', 'date'],
            'to_date'    => ['nullable', 'date'],
        ]);

        $mode      = $validated['mode'];
        $fromDate  = null;
        $toDate    = null;

        if ($mode === 'range') {
            // 期間指定時は from / to 必須
            $request->validate([
                'from_date' => ['required', 'date'],
                'to_date'   => ['required', 'date', 'after_or_equal:from_date'],
            ]);
            $fromDate = Carbon::parse($request->input('from_date'))->startOfDay();
            $toDate   = Carbon::parse($request->input('to_date'))->endOfDay();
        }

        $query = Reservation::with([
            'resort',
            'details' => fn($q) => $q->orderBy('id'),
        ])
            ->whereNull('printed_at'); // ★ 未印刷のみ

        switch ($mode) {
            case 'today':
                $today = Carbon::today();
                $query->whereDate('visit_date', $today->toDateString());
                break;

            case 'tomorrow':
                $tomorrow = Carbon::tomorrow();
                $query->whereDate('visit_date', $tomorrow->toDateString());
                break;

            case 'range':
                $query->whereBetween('visit_date', [
                    $fromDate->toDateString(),
                    $toDate->toDateString(),
                ]);
                break;

            case 'all_unprinted':
                // 条件なし（printed_at が null のすべて）
                break;
        }

        $reservations = $query
            ->orderBy('visit_date')
            ->orderBy('visit_time')
            ->get();

        if ($reservations->isEmpty()) {
            return back()->with('status', '条件に合致する未印刷の予約はありません。');
        }

        // ★ 印刷日時 & 印刷者を一括更新
        $userId = Auth::id();

        DB::transaction(function () use ($reservations, $userId) {
            $now = now();
            foreach ($reservations as $reservation) {
                $reservation->printed_at      = $now;
                $reservation->printed_user_id = $userId;
                $reservation->is_needs_confirmation = false;
                $reservation->save();
            }
        });

        // ★ まとめて1つのPDFにする
        $pdf = Pdf::loadView('reservations.bill_for_reserves', [
            'reservations' => $reservations,
        ])
            ->setPaper('A4', 'portrait');

        $fileName = 'reservation_slips_'
            . now()->format('Ymd_His')
            . '.pdf';

        return $pdf->download($fileName);
    }

    public function verifyChange(Reservation $reservation)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $reservation->is_needs_confirmation = false;
        $reservation->save();

        return back()->with('status', '変更を確認済みにしました。');
    }
    // ■ 追加: キャンセル確認済み処理
    // routes/web.php で定義するルートに対応させます
    public function verifyCancel($id)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        // 論理削除されているデータも含めて取得
        $reservation = Reservation::withTrashed()->findOrFail($id);

        $reservation->is_cancel_needs_confirmation = false;
        $reservation->save();

        return back()->with('status', 'キャンセルを確認済みにしました。');
    }

    /**
     * 要望コメントを確認済みにする
     */
    public function verifyComment(Reservation $reservation)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        // フラグを更新
        $reservation->update(['is_comment_checked' => true]);

        return back()->with('status', '要望コメントを確認済みにしました。');
    }

    /**
     * 利用者コメントを確認済みにする
     */
    public function verifyGuestComment(ReservationDetail $detail)
    {
        if (! $this->isMasterUser()) {
            abort(403);
        }

        $detail->update(['is_comment_checked' => true]);

        return back()->with('status', '利用者コメントを確認済みにしました。');
    }

}
