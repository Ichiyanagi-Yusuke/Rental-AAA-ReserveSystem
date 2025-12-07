<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            営業パターンマスタ
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- フラッシュメッセージ --}}
            @php $status = session('status'); @endphp
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
                <a href="{{ route('business-patterns.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                    新規パターン追加
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="px-4 py-2">コード</th>
                            <th class="px-4 py-2">名称</th>
                            <th class="px-4 py-2">営業/休業</th>
                            <th class="px-4 py-2">営業時間</th>
                            <th class="px-4 py-2">色</th>
                            <th class="px-4 py-2 text-right">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($patterns as $pattern)
                            <tr class="border-t">
                                <td class="px-4 py-2 whitespace-nowrap">
                                    <span class="font-mono text-xs sm:text-sm">{{ $pattern->code }}</span>
                                </td>
                                <td class="px-4 py-2">
                                    {{ $pattern->name }}
                                    @if ($pattern->description)
                                        <div class="text-[11px] text-gray-500">
                                            {{ $pattern->description }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    @if ($pattern->is_open)
                                        <span
                                            class="inline-flex items-center rounded-full bg-green-100 px-2 py-0.5 text-[11px] font-medium text-green-700">
                                            営業
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-[11px] font-medium text-red-700">
                                            休業
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-xs sm:text-sm">
                                    @if ($pattern->open_time && $pattern->close_time)
                                        {{ \Carbon\Carbon::parse($pattern->open_time)->format('H:i') }}
                                        〜
                                        {{ \Carbon\Carbon::parse($pattern->close_time)->format('H:i') }}
                                    @else
                                        <span class="text-gray-400">未設定</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    @if ($pattern->color)
                                        <div class="flex items-center gap-2">
                                            <span class="inline-block h-4 w-4 rounded-full border border-gray-200"
                                                style="background-color: {{ $pattern->color }};"></span>
                                            <span class="font-mono text-xs sm:text-sm text-gray-700">
                                                {{ $pattern->color }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs">未設定</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-right whitespace-nowrap">
                                    <a href="{{ route('business-patterns.edit', $pattern) }}"
                                        class="inline-flex items-center px-2.5 py-1 text-xs sm:text-sm rounded-md border border-indigo-500 text-indigo-600 hover:bg-indigo-50 mr-1">
                                        編集
                                    </a>
                                    <form action="{{ route('business-patterns.destroy', $pattern) }}" method="POST"
                                        class="inline" onsubmit="return confirm('削除してよろしいですか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-2.5 py-1 text-xs sm:text-sm rounded-md border border-red-500 text-red-600 hover:bg-red-50">
                                            削除
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                    登録されている営業パターンはありません。
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
