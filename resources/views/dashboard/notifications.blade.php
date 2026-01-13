<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            通知・確認事項
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                {{-- 予約変更確認 --}}
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
                                お客様によって内容が変更された予約です。
                            </p>
                        </div>
                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-full {{ $modifiedReservations->count() > 0 ? 'bg-red-100' : 'bg-gray-50' }}">
                            <span
                                class="text-xs font-bold {{ $modifiedReservations->count() > 0 ? 'text-red-600' : 'text-gray-400' }}">
                                !
                            </span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between text-xs">
                        <span
                            class="inline-flex items-center rounded-full px-2.5 py-1 {{ $modifiedReservations->count() > 0 ? 'bg-red-100 text-red-700 font-bold' : 'bg-gray-100 text-gray-600' }}">
                            {{ $modifiedReservations->count() }} 件
                        </span>
                        <span class="text-indigo-600 font-medium">確認する &rarr;</span>
                    </div>
                </a>

                {{-- キャンセル確認 --}}
                <a href="{{ route('reservations.index', ['status' => 'cancelled_needs_confirmation']) }}"
                    class="flex flex-col justify-between bg-white rounded-xl shadow-sm border p-4 sm:p-5 transition
                    {{ $cancelledReservations->count() > 0 ? 'border-gray-400 ring-2 ring-gray-200 hover:shadow-md' : 'border-gray-100 hover:border-gray-200' }}">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h3
                                class="text-sm font-semibold {{ $cancelledReservations->count() > 0 ? 'text-gray-800' : 'text-gray-900' }}">
                                キャンセル回収
                            </h3>
                            <p class="mt-1 text-xs text-gray-500">
                                印刷済みでキャンセルされた予約です。
                            </p>
                        </div>
                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-full {{ $cancelledReservations->count() > 0 ? 'bg-gray-200' : 'bg-gray-50' }}">
                            <span
                                class="text-xs font-bold {{ $cancelledReservations->count() > 0 ? 'text-gray-700' : 'text-gray-400' }}">
                                ×
                            </span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between text-xs">
                        <span
                            class="inline-flex items-center rounded-full px-2.5 py-1 {{ $cancelledReservations->count() > 0 ? 'bg-gray-800 text-white font-bold' : 'bg-gray-100 text-gray-500' }}">
                            {{ $cancelledReservations->count() }} 件
                        </span>
                        <span class="text-gray-600 font-medium">確認する &rarr;</span>
                    </div>
                </a>

                {{-- 代表者コメント確認 --}}
                <a href="{{ route('reservations.index', ['status' => 'comment_needs_confirmation']) }}"
                    class="flex flex-col justify-between bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5 hover:shadow-md transition 
                   {{ $commentPendingReservations->count() > 0 ? 'border-yellow-200 ring-2 ring-yellow-50' : 'hover:border-indigo-200' }}">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h3
                                class="text-sm font-semibold {{ $commentPendingReservations->count() > 0 ? 'text-yellow-700' : 'text-gray-900' }}">
                                代表者コメント
                            </h3>
                            <p class="mt-1 text-xs text-gray-500">
                                予約時の「その他ご要望」欄です。
                            </p>
                        </div>
                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-full {{ $commentPendingReservations->count() > 0 ? 'bg-yellow-100' : 'bg-gray-50' }}">
                            <span
                                class="text-xs font-bold {{ $commentPendingReservations->count() > 0 ? 'text-yellow-600' : 'text-gray-400' }}">
                                ?
                            </span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between text-xs">
                        <span
                            class="inline-flex items-center rounded-full px-2.5 py-1 {{ $commentPendingReservations->count() > 0 ? 'bg-yellow-100 text-yellow-800 font-bold' : 'bg-gray-100 text-gray-600' }}">
                            {{ $commentPendingReservations->count() }} 件
                        </span>
                        <span class="text-indigo-600 font-medium">確認する &rarr;</span>
                    </div>
                </a>

                {{-- 利用者コメント確認 --}}
                <a href="{{ route('reservations.index', ['status' => 'guest_comment_needs_confirmation']) }}"
                    class="flex flex-col justify-between bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5 hover:shadow-md transition 
                   {{ $guestCommentPendingReservations->count() > 0 ? 'border-orange-200 ring-2 ring-orange-50' : 'hover:border-indigo-200' }}">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h3
                                class="text-sm font-semibold {{ $guestCommentPendingReservations->count() > 0 ? 'text-orange-700' : 'text-gray-900' }}">
                                利用者コメント
                            </h3>
                            <p class="mt-1 text-xs text-gray-500">
                                利用者ごとの要望欄です。
                            </p>
                        </div>
                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-full {{ $guestCommentPendingReservations->count() > 0 ? 'bg-orange-100' : 'bg-gray-50' }}">
                            <span
                                class="text-xs font-bold {{ $guestCommentPendingReservations->count() > 0 ? 'text-orange-600' : 'text-gray-400' }}">
                                ?
                            </span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between text-xs">
                        <span
                            class="inline-flex items-center rounded-full px-2.5 py-1 {{ $guestCommentPendingReservations->count() > 0 ? 'bg-orange-100 text-orange-800 font-bold' : 'bg-gray-100 text-gray-600' }}">
                            {{ $guestCommentPendingReservations->count() }} 件
                        </span>
                        <span class="text-indigo-600 font-medium">確認する &rarr;</span>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
