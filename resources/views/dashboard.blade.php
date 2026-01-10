<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ダッシュボード
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- 上部に一言メッセージなど置きたければここに --}}
            <div class="mb-4">
                <p class="text-sm text-gray-600">
                    ようこそ。各種マスタや機能へアクセスできます。
                </p>
            </div>

            {{-- カードレイアウト --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                {{-- マスタ一覧カード --}}
                <a href="{{ route('masters.index') }}"
                    class="flex flex-col justify-between bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5 hover:shadow-md hover:border-indigo-200 transition">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">
                                マスタ一覧
                            </h3>
                            <p class="mt-1 text-xs text-gray-500">
                                リゾートマスタなど、各種マスタ管理画面への入口です。
                            </p>
                        </div>
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-50">
                            <span class="text-xs font-semibold text-indigo-600">
                                MST
                            </span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between text-xs">
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 bg-gray-100 text-gray-600">
                            一覧へ
                        </span>
                        <span class="inline-flex items-center text-indigo-600 font-medium">
                            開く
                            <svg class="ml-1 h-3 w-3" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div>
                </a>

                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">
                            予約管理
                        </h3>
                        <p class="text-sm text-gray-600">
                            社内用の予約登録・一覧を行います。
                        </p>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="{{ route('reservations.create.header') }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700">
                            新規予約登録
                        </a>
                        <a href="{{ route('reservations.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-semibold rounded-md text-gray-700 hover:bg-gray-50">
                            予約一覧
                        </a>
                    </div>
                </div>

                <a href="{{ route('reservations.index', ['filter' => 'today']) }}"
                    class="block bg-white shadow-sm rounded-lg p-5 hover:bg-gray-50 transition">
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">
                        本日の予約
                    </h3>
                    <p class="text-sm text-gray-500 mb-3">
                        本日来店予定の予約を一覧表示します。
                    </p>
                    <div class="text-xs text-gray-400">
                        代表者名 / 来店日 / 予約日時 / 人数 を確認できます。
                    </div>
                </a>

                {{-- 明日の予約カード --}}
                <a href="{{ route('reservations.index', ['filter' => 'tomorrow']) }}"
                    class="block bg-white shadow-sm rounded-lg p-5 hover:bg-gray-50 transition">
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">
                        明日の予約
                    </h3>
                    <p class="text-sm text-gray-500 mb-3">
                        明日来店予定の予約を一覧表示します。
                    </p>
                    <div class="text-xs text-gray-400">
                        前日準備用に、来店人数やメニュー構成を確認できます。
                    </div>
                </a>



                <a href="{{ route('reservations.print.form') }}"
                    class="block bg-white shadow-sm rounded-lg p-5 hover:bg-gray-50 transition">
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">
                        貸出票印刷
                    </h3>
                    <p class="text-sm text-gray-500 mb-3">
                        本日・明日・期間指定・全ての未印刷分から、貸出票をまとめて印刷します。
                    </p>
                    <div class="text-xs text-gray-400">
                        印刷済みの予約には印刷日時と印刷者が記録され、次回以降の対象外になります。
                    </div>
                </a>

                {{-- ブログ・お知らせ管理カード --}}
                <a href="{{ route('news-posts.index') }}"
                    class="flex flex-col justify-between bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5 hover:shadow-md hover:border-green-200 transition">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">
                                ブログ・お知らせ管理
                            </h3>
                            <p class="mt-1 text-xs text-gray-500">
                                HPに掲載するニュースやブログ記事を作成・編集します。
                            </p>
                        </div>
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-green-50">
                            <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between text-xs">
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 bg-gray-100 text-gray-600">
                            {{ \App\Models\NewsPost::count() }} 件の記事
                        </span>
                        <span class="inline-flex items-center text-green-600 font-medium">
                            編集する
                            <svg class="ml-1 h-3 w-3" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div>
                </a>


                {{-- データ分析カード（ここに追加） --}}
                <a href="{{ route('analysis.index') }}"
                    class="flex flex-col justify-between bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5 hover:shadow-md hover:border-blue-200 transition">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">
                                データ分析
                            </h3>
                            <p class="mt-1 text-xs text-gray-500">
                                予約状況の可視化や統計データを確認します。
                            </p>
                        </div>
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-50">
                            <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between text-xs">
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 bg-gray-100 text-gray-600">
                            分析メニュー
                        </span>
                        <span class="inline-flex items-center text-blue-600 font-medium">
                            開く
                            <svg class="ml-1 h-3 w-3" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div>
                </a>

                {{-- ▼ 追加：予約変更通知カード --}}
                <a href="{{ route('reservations.index', ['status' => 'needs_confirmation']) }}"
                    class="flex flex-col justify-between bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5 hover:shadow-md transition 
                   {{ $modifiedReservations->count() > 0 ? 'border-red-200 ring-2 ring-red-50' : 'hover:border-indigo-200' }}">

                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h3
                                class="text-sm font-semibold {{ $modifiedReservations->count() > 0 ? 'text-red-600' : 'text-gray-900' }}">
                                予約変更の確認
                            </h3>
                            <p class="mt-1 text-xs text-gray-500">
                                お客様によって内容が変更された予約です。内容を確認してください。
                            </p>
                        </div>
                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-full {{ $modifiedReservations->count() > 0 ? 'bg-red-100' : 'bg-gray-50' }}">
                            <svg class="h-5 w-5 {{ $modifiedReservations->count() > 0 ? 'text-red-600' : 'text-gray-400' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center justify-between text-xs">
                        <span
                            class="inline-flex items-center rounded-full px-2.5 py-1 
                            {{ $modifiedReservations->count() > 0 ? 'bg-red-100 text-red-700 font-bold' : 'bg-gray-100 text-gray-600' }}">
                            {{ $modifiedReservations->count() }} 件の未確認
                        </span>

                        <span class="inline-flex items-center text-indigo-600 font-medium">
                            確認する
                            <svg class="ml-1 h-3 w-3" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div>
                </a>
                {{-- ▲ 追加ここまで --}}

                {{-- ▼ 追加: キャンセル確認通知カード --}}
                <a href="{{ route('reservations.index', ['status' => 'cancelled_needs_confirmation']) }}"
                    class="flex flex-col justify-between bg-white rounded-xl shadow-sm border p-4 sm:p-5 transition
       {{ isset($cancelledReservations) && $cancelledReservations->count() > 0 ? 'border-gray-400 ring-2 ring-gray-200 hover:shadow-md' : 'border-gray-100 hover:border-gray-200' }}">

                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h3
                                class="text-sm font-semibold {{ isset($cancelledReservations) && $cancelledReservations->count() > 0 ? 'text-gray-800' : 'text-gray-900' }}">
                                キャンセル済みの回収
                            </h3>
                            <p class="mt-1 text-xs text-gray-500">
                                印刷済みですがキャンセルされました。<br>準備済みなら在庫を戻してください。
                            </p>
                        </div>
                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-full {{ isset($cancelledReservations) && $cancelledReservations->count() > 0 ? 'bg-gray-200' : 'bg-gray-50' }}">
                            <svg class="h-5 w-5 {{ isset($cancelledReservations) && $cancelledReservations->count() > 0 ? 'text-gray-700' : 'text-gray-400' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center justify-between text-xs">
                        @if (isset($cancelledReservations) && $cancelledReservations->count() > 0)
                            <span
                                class="inline-flex items-center rounded-full px-2.5 py-1 bg-gray-800 text-white font-bold">
                                {{ $cancelledReservations->count() }} 件の回収待ち
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full px-2.5 py-1 bg-gray-100 text-gray-500">
                                なし
                            </span>
                        @endif

                        <span class="inline-flex items-center text-gray-600 font-medium">
                            確認する
                            <svg class="ml-1 h-3 w-3" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div>
                </a>
                {{-- ▲ 追加ここまで --}}
                {{-- 今後、他機能のカードをここに増やしていける --}}
            </div>
        </div>
    </div>
</x-app-layout>
