<x-app-layout>
    @php
        $user = auth()->user();
        $isMasterUser = $user && in_array((int) $user->role, [0, 1], true);
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            マスタ一覧
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                {{-- 主要リゾートマスタ --}}
                <a href="{{ route('resorts.index') }}"
                    class="flex flex-col justify-between bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5 hover:shadow-md hover:border-indigo-200 transition">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">
                                主要リゾートマスタ
                            </h3>
                            <p class="mt-1 text-xs text-gray-500">
                                取扱いリゾートの一覧を確認できます。<br>
                                @if ($isMasterUser)
                                    新規登録・編集・削除が可能です。
                                @else
                                    一般ユーザーは参照のみ可能です。
                                @endif
                            </p>
                        </div>
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-50">
                            <span class="text-xs font-semibold text-indigo-600">
                                RES
                            </span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between text-xs">
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 bg-gray-100 text-gray-600">
                            リスト表示
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

                {{-- 今後マスタを増やす場合は、ここにカードを追加していける --}}
                {{--
                <a href="{{ route('something.index') }}" class="...">
                    ...
                </a>
                --}}
            </div>
        </div>
    </div>
</x-app-layout>
