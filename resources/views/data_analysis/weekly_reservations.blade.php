<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            週間予約推移（{{ $tableData[0]['displayDate'] }} 〜）
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- 戻るボタンなど --}}
            <div class="mb-4">
                <a href="{{ route('analysis.index') }}" class="text-sm text-indigo-600 hover:underline">
                    &laquo; 分析メニューへ戻る
                </a>
            </div>

            {{-- グラフエリア --}}
            <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">予約件数グラフ</h3>
                <div class="w-full h-64 sm:h-80">
                    <canvas id="reservationChart"></canvas>
                </div>
            </div>

            {{-- テーブルエリア --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">日付別予約数</h3>
                    <p class="text-xs text-gray-500 mt-1">行をクリックすると、その日の予約一覧へ移動します。</p>
                </div>
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 font-medium border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3">日付</th>
                            <th class="px-6 py-3 text-right">予約件数</th>
                            <th class="px-6 py-3 text-right">操作</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($tableData as $data)
                            <tr class="hover:bg-indigo-50 cursor-pointer transition"
                                onclick="window.location='{{ route('reservations.index', ['date' => $data['date']]) }}'">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $data['displayDate'] }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $data['count'] > 0 ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $data['count'] }} 件
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-indigo-600 text-xs">
                                    一覧を見る &rarr;
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('reservationChart').getContext('2d');

            // Controllerから渡されたデータ
            const labels = @json($chartLabels);
            const data = @json($chartData);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '予約件数',
                        data: data,
                        borderColor: 'rgb(79, 70, 229)', // Tailwind indigo-600
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        borderWidth: 2,
                        tension: 0.3, // 曲線の度合い
                        fill: true,
                        pointBackgroundColor: 'white',
                        pointBorderColor: 'rgb(79, 70, 229)',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // 凡例はシンプルにするため非表示
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1, // 整数で表示
                                precision: 0
                            },
                            grid: {
                                color: '#f3f4f6' // gray-100
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    // グラフクリック時の挙動（おまけ：グラフの点クリックでも遷移可能にする）
                    onClick: (e, activeElements, chart) => {
                        if (activeElements.length > 0) {
                            const index = activeElements[0].index;
                            // テーブルデータと同じ順序なので、日付データを再構築して遷移URLを作る必要がある
                            // ここではシンプルにするため実装していませんが、必要に応じて追加可能です
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
