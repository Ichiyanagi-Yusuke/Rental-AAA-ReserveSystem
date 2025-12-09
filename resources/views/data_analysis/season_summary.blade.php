<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            シーズンサマリ分析
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('analysis.index') }}" class="text-sm text-indigo-600 hover:underline">
                    &laquo; 分析メニューへ戻る
                </a>
            </div>

            {{-- 1. 総件数セクション --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 text-center border-l-4 border-indigo-500">
                    <p class="text-gray-500 text-sm font-medium">総予約件数 (件)</p>
                    <p class="text-4xl font-bold text-gray-800 mt-2">{{ number_format($totalReservations) }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 text-center border-l-4 border-green-500">
                    <p class="text-gray-500 text-sm font-medium">総利用者数 (人)</p>
                    <p class="text-4xl font-bold text-gray-800 mt-2">{{ number_format($totalGuests) }}</p>
                </div>
            </div>

            {{-- 2. グラフセクション --}}
            {{-- グリッドは自動で折り返されるため、そのまま追加要素を並べます --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- メニュー割合 --}}
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <h3 class="text-md font-bold text-gray-700 mb-4 text-center">利用メニュー割合</h3>
                    <div class="h-64">
                        <canvas id="menuChart"></canvas>
                    </div>
                </div>

                {{-- 男女比 --}}
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <h3 class="text-md font-bold text-gray-700 mb-4 text-center">男女比 (全利用者)</h3>
                    <div class="h-64">
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>

                {{-- 子供比率 --}}
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <h3 class="text-md font-bold text-gray-700 mb-4 text-center">大人・子供比率</h3>
                    <div class="h-64">
                        <canvas id="childChart"></canvas>
                    </div>
                </div>

                {{-- ★ 追加: ウェアサイズ割合 --}}
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <h3 class="text-md font-bold text-gray-700 mb-4 text-center">ウェアサイズ割合</h3>
                    <div class="h-64">
                        <canvas id="wearSizeChart"></canvas>
                    </div>
                </div>

                {{-- ★ 追加: 利用スキー場割合 --}}
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <h3 class="text-md font-bold text-gray-700 mb-4 text-center">利用スキー場割合</h3>
                    <div class="h-64">
                        <canvas id="resortChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- 3. ランキングセクション --}}
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">サイズ別傾向トップ5</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- 男性 --}}
                <div class="space-y-4">
                    <div class="bg-blue-50 p-3 rounded-t-lg border-b border-blue-200">
                        <h4 class="font-bold text-blue-800 text-center">男性 (Men)</h4>
                    </div>
                    <div class="bg-white shadow-sm rounded-lg p-4">
                        <p class="text-sm font-semibold text-gray-600 mb-2">多い身長 (cm)</p>
                        <ul class="text-sm space-y-1">
                            @forelse($heightMen as $item)
                                <li class="flex justify-between border-b border-gray-100 py-1 last:border-0">
                                    <span>{{ $item->height }} cm</span>
                                    <span class="font-mono">{{ $item->count }}人</span>
                                </li>
                            @empty
                                <li class="text-gray-400 text-xs">データなし</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="bg-white shadow-sm rounded-lg p-4">
                        <p class="text-sm font-semibold text-gray-600 mb-2">多い足サイズ (cm)</p>
                        <ul class="text-sm space-y-1">
                            @forelse($footMen as $item)
                                <li class="flex justify-between border-b border-gray-100 py-1 last:border-0">
                                    <span>{{ $item->foot_size }} cm</span>
                                    <span class="font-mono">{{ $item->count }}人</span>
                                </li>
                            @empty
                                <li class="text-gray-400 text-xs">データなし</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                {{-- 女性 --}}
                <div class="space-y-4">
                    <div class="bg-pink-50 p-3 rounded-t-lg border-b border-pink-200">
                        <h4 class="font-bold text-pink-800 text-center">女性 (Women)</h4>
                    </div>
                    <div class="bg-white shadow-sm rounded-lg p-4">
                        <p class="text-sm font-semibold text-gray-600 mb-2">多い身長 (cm)</p>
                        <ul class="text-sm space-y-1">
                            @forelse($heightWomen as $item)
                                <li class="flex justify-between border-b border-gray-100 py-1 last:border-0">
                                    <span>{{ $item->height }} cm</span>
                                    <span class="font-mono">{{ $item->count }}人</span>
                                </li>
                            @empty
                                <li class="text-gray-400 text-xs">データなし</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="bg-white shadow-sm rounded-lg p-4">
                        <p class="text-sm font-semibold text-gray-600 mb-2">多い足サイズ (cm)</p>
                        <ul class="text-sm space-y-1">
                            @forelse($footWomen as $item)
                                <li class="flex justify-between border-b border-gray-100 py-1 last:border-0">
                                    <span>{{ $item->foot_size }} cm</span>
                                    <span class="font-mono">{{ $item->count }}人</span>
                                </li>
                            @empty
                                <li class="text-gray-400 text-xs">データなし</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                {{-- 子供 --}}
                <div class="space-y-4">
                    <div class="bg-yellow-50 p-3 rounded-t-lg border-b border-yellow-200">
                        <h4 class="font-bold text-yellow-800 text-center">子供 (Kids)</h4>
                    </div>
                    <div class="bg-white shadow-sm rounded-lg p-4">
                        <p class="text-sm font-semibold text-gray-600 mb-2">多い身長 (cm)</p>
                        <ul class="text-sm space-y-1">
                            @forelse($heightKids as $item)
                                <li class="flex justify-between border-b border-gray-100 py-1 last:border-0">
                                    <span>{{ $item->height }} cm</span>
                                    <span class="font-mono">{{ $item->count }}人</span>
                                </li>
                            @empty
                                <li class="text-gray-400 text-xs">データなし</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="bg-white shadow-sm rounded-lg p-4">
                        <p class="text-sm font-semibold text-gray-600 mb-2">多い足サイズ (cm)</p>
                        <ul class="text-sm space-y-1">
                            @forelse($footKids as $item)
                                <li class="flex justify-between border-b border-gray-100 py-1 last:border-0">
                                    <span>{{ $item->foot_size }} cm</span>
                                    <span class="font-mono">{{ $item->count }}人</span>
                                </li>
                            @empty
                                <li class="text-gray-400 text-xs">データなし</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 共通オプション
            const commonPieOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 10
                        }
                    }
                }
            };

            // 1. メニュー割合
            new Chart(document.getElementById('menuChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($menuLabels),
                    datasets: [{
                        data: @json($menuCounts),
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)', 'rgba(255, 99, 132, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)', 'rgba(153, 102, 255, 0.6)',
                            'rgba(255, 159, 64, 0.6)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: commonPieOptions
            });

            // 2. 男女比
            new Chart(document.getElementById('genderChart'), {
                type: 'pie',
                data: {
                    labels: @json($genderLabels),
                    datasets: [{
                        data: @json($genderData),
                        backgroundColor: ['#3b82f6', '#ec4899'],
                        borderWidth: 1
                    }]
                },
                options: commonPieOptions
            });

            // 3. 子供比率
            new Chart(document.getElementById('childChart'), {
                type: 'pie',
                data: {
                    labels: @json($childRatioLabels),
                    datasets: [{
                        data: @json($childRatioData),
                        backgroundColor: ['#9ca3af', '#fbbf24'],
                        borderWidth: 1
                    }]
                },
                options: commonPieOptions
            });

            // ★ 追加 4. ウェアサイズ割合
            new Chart(document.getElementById('wearSizeChart'), {
                type: 'bar', // バーチャートの方が見やすい場合が多いですが、割合ならPieでも可。ここでは円グラフにします。
                // 見やすさのためDoughnutにします
                type: 'doughnut',
                data: {
                    labels: @json($wearSizeLabels),
                    datasets: [{
                        data: @json($wearSizeCounts),
                        backgroundColor: [
                            '#fca5a5', '#fdba74', '#fcd34d', '#bef264', '#86efac',
                            '#6ee7b7', '#5eead4', '#67e8f9', '#7dd3fc', '#93c5fd'
                        ], // 色数が足りない場合はループします
                        borderWidth: 1
                    }]
                },
                options: commonPieOptions
            });

            // ★ 追加 5. スキー場割合
            new Chart(document.getElementById('resortChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($resortLabels),
                    datasets: [{
                        data: @json($resortCounts),
                        backgroundColor: [
                            '#c084fc', '#a855f7', '#7e22ce', '#db2777', '#be185d'
                        ],
                        borderWidth: 1
                    }]
                },
                options: commonPieOptions
            });
        });
    </script>
</x-app-layout>
