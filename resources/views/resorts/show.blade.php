<x-app-layout>
    @php
        $user = auth()->user();
        $isMasterUser = $user && in_array((int) $user->role, [0, 1], true);
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            リゾート詳細
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-4 sm:p-6">
                {{-- 上部ヘッダー（名称 + 状態） --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ $resort->name }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">
                            ID: {{ $resort->id }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span
                            class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium
                            {{ $resort->sales_stop ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                            {{ $resort->sales_stop ? '販売停止' : '販売中' }}
                        </span>
                    </div>
                </div>

                {{-- 詳細情報（レスポンシブ） --}}
                <div class="border-t border-gray-200 pt-4">
                    <dl class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-4 text-sm">
                        <div>
                            <dt class="text-gray-500">通常料金</dt>
                            <dd class="mt-1 text-gray-900">
                                {{ number_format($resort->price) }} 円
                            </dd>
                        </div>

                        <div>
                            <dt class="text-gray-500">休日料金</dt>
                            <dd class="mt-1 text-gray-900">
                                {{ number_format($resort->holiday_price) }} 円
                            </dd>
                        </div>

                        <div>
                            <dt class="text-gray-500">チケット枚数</dt>
                            <dd class="mt-1 text-gray-900">
                                {{ $resort->ticket }} 枚
                            </dd>
                        </div>

                        <div>
                            <dt class="text-gray-500">販売状態</dt>
                            <dd class="mt-1 text-gray-900">
                                {{ $resort->sales_stop ? '停止中' : '販売中' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-gray-500">作成者</dt>
                            <dd class="mt-1 text-gray-900">
                                {{ optional($resort->createUser)->name ?? '不明' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-gray-500">最終更新者</dt>
                            <dd class="mt-1 text-gray-900">
                                {{ optional($resort->updateUser)->name ?? '不明' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-gray-500">作成日時</dt>
                            <dd class="mt-1 text-gray-900">
                                {{ optional($resort->created_at)->format('Y-m-d H:i') }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-gray-500">更新日時</dt>
                            <dd class="mt-1 text-gray-900">
                                {{ optional($resort->updated_at)->format('Y-m-d H:i') }}
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- ボタン群 --}}
                <div class="mt-6 flex flex-col-reverse sm:flex-row sm:justify-between gap-2">
                    <a href="{{ route('resorts.index') }}"
                        class="inline-flex justify-center px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">
                        一覧に戻る
                    </a>

                    @if ($isMasterUser)
                        <div class="flex flex-col sm:flex-row gap-2">
                            <a href="{{ route('resorts.edit', $resort) }}"
                                class="inline-flex justify-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                                編集する
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
