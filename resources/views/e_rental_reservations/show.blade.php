<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Eレンタル予約詳細') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- 操作ボタンエリア --}}
            <div class="flex justify-between items-center">
                <a href="{{ route('reservations.index') }}" class="text-gray-600 hover:text-gray-900">
                    &larr; 一覧に戻る
                </a>

                {{-- 本予約への変換が未完了の場合のみ表示する等の制御も可能 --}}
                {{-- @if ($reservation->import_status == 0)
                    <span class="bg-yellow-100 text-yellow-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">未反映</span>
                @else
                    <span class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">反映済</span>
                @endif --}}
            </div>

            {{-- 1. 予約基本情報 & 代表者情報 --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">基本情報 / 代表者情報</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- 左カラム --}}
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs text-gray-500">予約番号 (Eレンタル)</label>
                                <div class="font-semibold text-lg">{{ $reservation->reservation_number }}</div>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">来店日時</label>
                                <div>
                                    {{ $reservation->visit_date->format('Y年m月d日') }}
                                    {{ $reservation->visit_time ? $reservation->visit_time->format('H:i') : '' }}
                                </div>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">人数</label>
                                <div>{{ $reservation->number_of_people }} 名</div>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">合計金額</label>
                                <div class="font-bold text-lg">¥{{ number_format($reservation->total_price) }}</div>
                            </div>
                        </div>

                        {{-- 右カラム --}}
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs text-gray-500">代表者名</label>
                                <div class="font-semibold">{{ $reservation->rep_name }} <span
                                        class="text-sm font-normal text-gray-600">({{ $reservation->rep_kana }})</span>
                                </div>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">電話番号</label>
                                <div>{{ $reservation->phone }}</div>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">メールアドレス</label>
                                <div>
                                    @if ($reservation->email_pc)
                                        PC: {{ $reservation->email_pc }}<br>
                                    @endif
                                    @if ($reservation->email_mobile)
                                        携帯: {{ $reservation->email_mobile }}
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">住所</label>
                                <div>{{ $reservation->address }}</div>
                            </div>
                        </div>
                    </div>

                    @if ($reservation->comment)
                        {{-- コメントエリア --}}
                        @if ($reservation->comment)
                            <div
                                class="mt-6 p-4 rounded-lg {{ $reservation->is_comment_checked ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                                <div class="flex justify-between items-start mb-2">
                                    <label
                                        class="text-xs font-bold {{ $reservation->is_comment_checked ? 'text-green-700' : 'text-red-700' }}">
                                        @if ($reservation->is_comment_checked)
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                確認済みコメント
                                            </span>
                                        @else
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                    </path>
                                                </svg>
                                                未確認コメント
                                            </span>
                                        @endif
                                    </label>

                                    {{-- 確認ボタンフォーム --}}
                                    <form action="{{ route('e_rental_reservations.check_comment', $reservation->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="text-xs underline {{ $reservation->is_comment_checked ? 'text-green-600 hover:text-green-800' : 'text-red-600 hover:text-red-800 font-bold' }}">
                                            {{ $reservation->is_comment_checked ? '未確認に戻す' : '確認済みにする' }}
                                        </button>
                                    </form>
                                </div>

                                <div class="text-sm whitespace-pre-wrap text-gray-800">{{ $reservation->comment }}
                                </div>
                            </div>
                        @else
                            <div class="mt-6 text-sm text-gray-400">コメントなし</div>
                        @endif
                    @endif
                </div>
            </div>

            {{-- 2. 利用者明細 (レンタルアイテム) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">利用者詳細 / レンタル内容</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        利用者名</th>
                                    <th
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        性別/年齢</th>
                                    <th
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        体格情報</th>
                                    <th
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        スタンス</th>
                                    <th
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">
                                        レンタルアイテム</th>
                                    <th
                                        class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        小計</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($reservation->details as $detail)
                                    <tr>
                                        <td class="px-3 py-4 whitespace-nowrap font-medium">
                                            {{ $detail->guest_name }}
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $detail->gender }} / {{ $detail->age }}歳
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div>身長: {{ $detail->height }}cm</div>
                                            <div>足: {{ $detail->foot_size }}cm</div>
                                            <div>体重: {{ $detail->weight }}kg</div>
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $detail->stance }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-pre-line">
                                            {{ $detail->items_text }}
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap text-right text-sm font-semibold">
                                            ¥{{ number_format($detail->subtotal_price) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
