<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Assign Guru ke Mapel</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 bg-gradient-to-r from-green-500 to-teal-600 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-white">Kelola Pengampu Mata Pelajaran</h3>
                    <p class="text-sm text-green-100 mt-1">Klik checkbox untuk assign/unassign guru ke mata pelajaran (auto-save)</p>
                </div>

                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                    ID
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-12 bg-gray-50 z-10">
                                    Nama Guru
                                </th>
                                @foreach($mapels as $mapel)
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-5 h-5 text-indigo-600 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        <span>{{ $mapel->nama_mapel }}</span>
                                        <span class="text-xs text-gray-400 mt-1">({{ $mapel->durasi }} Jam)</span>
                                    </div>
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($gurus as $guru)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white">
                                    #{{ $guru->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap sticky left-12 bg-white">
                                    <div class="flex items-center">
                                        @if($guru->photo)
                                            <img src="{{ asset('storage/' . $guru->photo) }}" class="w-10 h-10 rounded-full object-cover border-2 border-green-500">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-teal-600 flex items-center justify-center text-white font-bold">
                                                {{ strtoupper(substr($guru->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $guru->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $guru->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                @foreach($mapels as $mapel)
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input
                                                type="checkbox"
                                                class="sr-only peer mapel-checkbox"
                                                data-guru-id="{{ $guru->id }}"
                                                data-mapel-id="{{ $mapel->id }}"
                                                {{ $guru->mapels->contains($mapel->id) ? 'checked' : '' }}
                                                onchange="toggleMapel(this)">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                        </label>
                                    </div>
                                </td>
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ count($mapels) + 2 }}" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        <p class="font-medium">Belum ada data guru</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Summary Footer -->
                @if($gurus->count() > 0)
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between text-sm text-gray-600">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Total {{ $gurus->count() }} Guru
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Total {{ $mapels->count() }} Mata Pelajaran
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 shadow-xl">
            <div class="flex items-center">
                <svg class="animate-spin h-8 w-8 text-green-600 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-700 font-medium">Menyimpan...</span>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="hidden fixed bottom-4 right-4 bg-white border-l-4 border-green-500 rounded-lg shadow-lg p-4 z-50 transform transition-all duration-300">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <p class="font-medium text-gray-900" id="toastTitle">Berhasil!</p>
                <p class="text-sm text-gray-600" id="toastMessage">Mapel berhasil diupdate</p>
            </div>
        </div>
    </div>

    <script>
        function toggleMapel(checkbox) {
            const guruId = checkbox.dataset.guruId;
            const mapelId = checkbox.dataset.mapelId;
            const isAssigned = checkbox.checked;

            // Show loading
            document.getElementById('loadingOverlay').classList.remove('hidden');

            // Send AJAX request
            fetch('{{ route("admin.guru-mapel.toggle") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    guru_id: guruId,
                    mapel_id: mapelId,
                    is_assigned: isAssigned
                })
            })
            .then(response => response.json())
            .then(data => {
                // Hide loading
                document.getElementById('loadingOverlay').classList.add('hidden');

                if (data.success) {
                    // Show success toast
                    showToast('Berhasil!', data.message);
                } else {
                    // Revert checkbox if failed
                    checkbox.checked = !isAssigned;
                    showToast('Gagal!', 'Terjadi kesalahan, silakan coba lagi', true);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Hide loading
                document.getElementById('loadingOverlay').classList.add('hidden');
                // Revert checkbox
                checkbox.checked = !isAssigned;
                showToast('Error!', 'Terjadi kesalahan koneksi', true);
            });
        }

        function showToast(title, message, isError = false) {
            const toast = document.getElementById('toast');
            const toastTitle = document.getElementById('toastTitle');
            const toastMessage = document.getElementById('toastMessage');

            toastTitle.textContent = title;
            toastMessage.textContent = message;

            // Change color for error
            if (isError) {
                toast.classList.remove('border-green-500');
                toast.classList.add('border-red-500');
                toast.querySelector('svg').classList.remove('text-green-500');
                toast.querySelector('svg').classList.add('text-red-500');
            } else {
                toast.classList.remove('border-red-500');
                toast.classList.add('border-green-500');
                toast.querySelector('svg').classList.remove('text-red-500');
                toast.querySelector('svg').classList.add('text-green-500');
            }

            // Show toast
            toast.classList.remove('hidden');

            // Hide after 3 seconds
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }
    </script>
</x-app-layout>
