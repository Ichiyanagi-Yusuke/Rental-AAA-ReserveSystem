<x-app-layout>

    @php
        $user = auth()->user();
        $isMasterUser = $user && in_array((int) $user->role, [0, 1], true);
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            主要リゾートマスタ
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @php
                $status = session('status');
            @endphp

            @if ($status)
                @php
                    $type = is_array($status) ? $status['type'] ?? 'success' : 'success';
                    $message = is_array($status) ? $status['message'] ?? '' : $status;

                    $styles = match ($type) {
                        'success' => 'border-green-200 bg-green-50 text-green-800',
                        'error' => 'border-red-200 bg-red-50 text-red-800',
                        default => 'border-gray-200 bg-gray-50 text-gray-800',
                    };
                @endphp

                <div class="mb-4 rounded-md border px-4 py-3 text-sm {{ $styles }}">
                    {{ $message }}
                </div>
            @endif


            <div class="mb-4 flex justify-end">
                @if ($isMasterUser)
                    <a href="{{ route('resorts.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                        新規リゾート追加
                    </a>
                @endif
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                {{-- ▼ モバイル表示（〜sm）: カード型リスト --}}
                <div class="sm:hidden divide-y">
                    @forelse ($resorts as $resort)
                        <div class="px-4 py-3 flex flex-col gap-2">
                            <div class="flex justify-between items-center">
                                <div>
                                    {{-- 名称リンク：下線なし、ホバーで色だけ変える --}}
                                    <a href="{{ route('resorts.show', $resort) }}"
                                        class="text-sm font-semibold text-gray-900 hover:text-indigo-600">
                                        {{ $resort->name }}
                                    </a>
                                </div>
                                @if ($isMasterUser)
                                    <div class="flex items-center space-x-2">
                                        {{-- 編集ボタン風 --}}
                                        <a href="{{ route('resorts.edit', $resort) }}"
                                            class="inline-flex items-center px-3 py-1 rounded-full border border-indigo-500 text-[11px] font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100">
                                            編集
                                        </a>
                                        {{-- 削除ボタン風 --}}
                                        <form action="{{ route('resorts.destroy', $resort) }}" method="POST"
                                            onsubmit="return confirm('削除してよろしいですか？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1 rounded-full border border-red-500 text-[11px] font-medium text-red-600 bg-red-50 hover:bg-red-100">
                                                削除
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-[11px] text-gray-400">
                                        参照のみ
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="px-4 py-4 text-center text-gray-500 text-sm">
                            登録されているリゾートはありません。
                        </div>
                    @endforelse
                </div>

                {{-- ▼ タブレット以上（sm〜）: テーブル表示 --}}
                <div class="hidden sm:block overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left">名称</th>
                                <th class="px-4 py-2 text-right">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($resorts as $resort)
                                <tr class="border-t">
                                    <td class="px-4 py-2">
                                        {{-- 名称リンク：下線なし、ホバーで色だけ変える --}}
                                        <a href="{{ route('resorts.show', $resort) }}"
                                            class="text-sm text-gray-900 hover:text-indigo-600">
                                            {{ $resort->name }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        @if ($isMasterUser)
                                            {{-- 編集ボタン --}}
                                            <a href="{{ route('resorts.edit', $resort) }}"
                                                class="inline-flex items-center px-3 py-1 mr-2 rounded-md bg-indigo-600 text-white text-xs font-medium hover:bg-indigo-700">
                                                編集
                                            </a>

                                            {{-- 削除ボタン --}}
                                            <form action="{{ route('resorts.destroy', $resort) }}" method="POST"
                                                class="inline" onsubmit="return confirm('削除してよろしいですか？');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 rounded-md bg-red-600 text-white text-xs font-medium hover:bg-red-700">
                                                    削除
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs">参照のみ</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-4 py-4 text-center text-gray-500" colspan="2">
                                        登録されているリゾートはありません。
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
