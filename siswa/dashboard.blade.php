<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Siswa</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg shadow-lg p-6 text-white">
                <h3 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                <p class="mt-2 text-blue-100">Berikut adalah ringkasan nilai dan prestasi Anda</p>
            </div>

            <!-- Overall Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Total Nilai -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Total Nilai</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalNilai }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Rata-rata Keseluruhan -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Rata-rata</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $rataRataKeseluruhan }}</p>
                            <span class="inline-block mt-2 px-2 py-1 text-xs font-semibold rounded-full
                                {{ $rataRataKeseluruhan >= 90 ? 'bg-green-100 text-green-800' : '' }}
                                {{ $rataRataKeseluruhan >= 75 && $rataRataKeseluruhan < 90 ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $rataRataKeseluruhan >= 60 && $rataRataKeseluruhan < 75 ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $rataRataKeseluruhan < 60 ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $rataRataKeseluruhan >= 90 ? 'Excellent' : ($rataRataKeseluruhan >= 75 ? 'Good' : ($rataRataKeseluruhan >= 60 ? 'Average' : 'Need Improvement')) }}
                            </span>
                        </div>
                        <div class="bg-indigo-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Nilai Tertinggi -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Nilai Tertinggi</p>
                            <p class="text-3xl font-bold text-green-600 mt-2">{{ $nilaiTertinggi }}</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Nilai Terendah -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Nilai Terendah</p>
                            <p class="text-3xl font-bold text-red-600 mt-2">{{ $nilaiTerendah }}</p>
                        </div>
                        <div class="bg-red-100 rounded-full p-3">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart & Statistics Per Mapel -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Chart -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Grafik Rata-rata Per Mata Pelajaran
                    </h4>
                    <canvas id="nilaiChart" class="w-full" style="max-height: 300px;"></canvas>
                </div>

                <!-- Statistics Per Mapel -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Statistik Per Mata Pelajaran
                    </h4>
                    <div class="space-y-4 max-h-80 overflow-y-auto">
                        @forelse($statistikPerMapel as $stat)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="font-semibold text-gray-900">{{ $stat['mapel'] }}</h5>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    {{ $stat['rata_rata'] >= 90 ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $stat['rata_rata'] >= 75 && $stat['rata_rata'] < 90 ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $stat['rata_rata'] >= 60 && $stat['rata_rata'] < 75 ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $stat['rata_rata'] < 60 ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $stat['label'] }}
                                </span>
                            </div>
                            <div class="grid grid-cols-3 gap-2 text-sm">
                                <div>
                                    <p class="text-gray-500">Rata-rata</p>
                                    <p class="font-bold text-indigo-600">{{ $stat['rata_rata'] }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Tertinggi</p>
                                    <p class="font-bold text-green-600">{{ $stat['tertinggi'] }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Terendah</p>
                                    <p class="font-bold text-red-600">{{ $stat['terendah'] }}</p>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Total {{ $stat['jumlah'] }} nilai</p>
                        </div>
                        @empty
                        <p class="text-gray-500 text-center py-4">Belum ada data nilai</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Detail Nilai Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 bg-gradient-to-r from-indigo-500 to-purple-600 border-b">
                    <h4 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        Riwayat Nilai Detail
                    </h4>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($nilais as $nilai)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $nilai->tanggal->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-purple-400 to-indigo-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $nilai->mapel->nama_mapel }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $nilai->keterangan }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($nilai->guru->photo)
                                            <img src="{{ asset('storage/' . $nilai->guru->photo) }}" class="w-8 h-8 rounded-full object-cover mr-2">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-400 to-teal-600 flex items-center justify-center text-white text-xs font-bold mr-2">
                                                {{ strtoupper(substr($nilai->guru->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <span class="text-sm text-gray-900">{{ $nilai->guru->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $nilai->mapel->durasi }} Jam
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                                        {{ $nilai->nilai >= 90 ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $nilai->nilai >= 75 && $nilai->nilai < 90 ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $nilai->nilai >= 60 && $nilai->nilai < 75 ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $nilai->nilai < 60 ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ $nilai->nilai }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 text-lg font-medium">Belum ada data nilai</p>
                                        <p class="text-gray-400 text-sm mt-1">Nilai akan muncul setelah guru menginput</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('nilaiChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Rata-rata Nilai',
                    data: @json($chartData),
                    backgroundColor: @json($chartColors),
                    borderWidth: 0,
                    borderRadius: 8,
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
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.parsed.y.toFixed(2);

                                let category = '';
                                if (context.parsed.y >= 90) category = ' (Excellent)';
                                else if (context.parsed.y >= 75) category = ' (Good)';
                                else if (context.parsed.y >= 60) category = ' (Average)';
                                else category = ' (Need Improvement)';

                                return label + category;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            stepSize: 20
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
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
    </script>
</x-app-layout>
