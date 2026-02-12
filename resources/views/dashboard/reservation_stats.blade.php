<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            予約回数実績（{{ $tableData[count($tableData)-1]['displayDate'] }} 〜 {{ $tableData[0]['displayDate'] }}）
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- 戻るボタン --}}
            <div class="mb-4">
                <a href="{{ route('dashboard') }}" class="text-sm text-indigo-600 hover:underline">
                    &laquo; ダッシュボードへ戻る
                </a>
            </div>

            {{-- グラフエリア --}}
            <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">日別予約登録件数グラフ（過去4週間）</h3>
                <div class="w-full h-64 sm:h-80">
                    <canvas id="reservationStatsChart"></canvas>
                </div>
            </div>

            {{-- テーブルエリア --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">日付別予約登録数</h3>
                    <p class="text-xs text-gray-500 mt-1">予約が登録された日（created_at）を基準にカウントしています。</p>
                </div>
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 font-medium border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3">日付</th>
                            <th class="px-6 py-3 text-right">予約登録件数</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($tableData as $data)
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $data['displayDate'] }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $data['count'] > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $data['count'] }} 件
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- 合計表示 --}}
                <div class="p-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-700">4週間合計</span>
                        <span class="text-lg font-bold text-emerald-600">{{ $totalCount }} 件</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('reservationStatsChart').getContext('2d');

            // Controllerから渡されたデータ
            const labels = @json($chartLabels);
            const data = @json($chartData);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '予約登録件数',
                        data: data,
                        backgroundColor: 'rgba(16, 185, 129, 0.6)', // Tailwind emerald-500
                        borderColor: 'rgb(16, 185, 129)',
                        borderWidth: 1,
                        borderRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
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
                                stepSize: 1,
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
                    }
                }
            });
        });
    </script>
</x-app-layout>
