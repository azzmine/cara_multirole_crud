<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Nilai - {{ $mapel->nama_mapel }}
        </h2>
    </x-slot>
<style>
.select2-container--default .select2-selection--single {
    border: 1px solid #d1d5db !important;
    border-radius: 0.5rem !important;
    height: 42px !important;
    padding: 6px 12px !important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 28px !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 40px !important;
}
</style></style>
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

            <!-- Mapel Info Card -->
            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-lg shadow-lg p-6 mb-6">
                <div class="flex items-center justify-between text-white">
                    <div>
                        <h3 class="text-2xl font-bold">{{ $mapel->nama_mapel }}</h3>
                        <p class="text-purple-100 mt-1">Durasi: {{ $mapel->durasi }} Jam per Pertemuan</p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold">{{ $nilais->total() }}</div>
                        <div class="text-sm text-purple-100">Total Nilai</div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900">Daftar Nilai</h4>
                        <p class="text-sm text-gray-500 mt-1">Kelola nilai siswa untuk mata pelajaran ini</p>
                    </div>
                    <button onclick="openCreateModal()" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Nilai
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($nilais as $index => $nilai)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $nilais->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($nilai->siswa->photo)
                                            <img src="{{ asset('storage/' . $nilai->siswa->photo) }}" class="w-8 h-8 rounded-full object-cover mr-3">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center text-white text-xs font-bold mr-3">
                                                {{ strtoupper(substr($nilai->siswa->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <span class="text-sm font-medium text-gray-900">{{ $nilai->siswa->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $nilai->tanggal->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $nilai->keterangan }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                                        {{ $nilai->nilai >= 75 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $nilai->nilai }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $mapel->durasi }} Jam
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button onclick='openEditModal(@json($nilai))' class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </button>
                                    <form action="{{ route('guru.nilais.destroy', [$mapel, $nilai]) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus nilai ini?')">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada data nilai
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($nilais->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $nilais->links() }}
                </div>
                @endif
            </div>

            <div class="mt-4">
                <a href="{{ route('guru.mapels.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Mapel
                </a>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div id="createModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-lg bg-white">
            <div class="flex justify-between items-center pb-3 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Tambah Nilai</h3>
                <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form action="{{ route('guru.nilais.store', $mapel) }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Siswa <span class="text-red-500">*</span></label>
                    <select name="siswa_id" id="siswa_id_create" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">Ketik atau pilih siswa...</option>
                        @foreach($siswas as $siswa)
                            <option value="{{ $siswa->id }}">{{ $siswa->name }} - {{ $siswa->email }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan/Nama Tugas <span class="text-red-500">*</span></label>
                    <input type="text" name="keterangan" required placeholder="Contoh: UTS, Tugas Kelompok, Quiz 1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nilai (0-100) <span class="text-red-500">*</span></label>
                    <input type="number" name="nilai" required min="0" max="100" maxlength="3" oninput="if(this.value.length > 3) this.value = this.value.slice(0,3); if(this.value > 100) this.value = 100;" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="0-100">
                </div>
                <div class="flex justify-end space-x-2 pt-4 border-t">
                    <button type="button" onclick="closeCreateModal()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-lg bg-white">
            <div class="flex justify-between items-center pb-3 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Edit Nilai</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="editForm" method="POST" class="mt-4">
                @csrf @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Siswa <span class="text-red-500">*</span></label>
                    <select id="edit_siswa_id" name="siswa_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @foreach($siswas as $siswa)
                            <option value="{{ $siswa->id }}">{{ $siswa->name }} - {{ $siswa->email }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" id="edit_tanggal" name="tanggal" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan/Nama Tugas <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_keterangan" name="keterangan" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nilai (0-100) <span class="text-red-500">*</span></label>
                    <input type="number" id="edit_nilai" name="nilai" required min="0" max="100" maxlength="3" oninput="if(this.value.length > 3) this.value = this.value.slice(0,3); if(this.value > 100) this.value = 100;" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div class="flex justify-end space-x-2 pt-4 border-t">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Initialize Select2 for Create Modal
        function initializeSelect2Create() {
            $('#siswa_id_create').select2({
                dropdownParent: $('#createModal'),
                placeholder: 'Ketik nama atau email siswa...',
                allowClear: true,
                width: '100%'
            });
        }

        // Initialize Select2 for Edit Modal
        function initializeSelect2Edit() {
            $('#edit_siswa_id').select2({
                dropdownParent: $('#editModal'),
                placeholder: 'Ketik nama atau email siswa...',
                allowClear: true,
                width: '100%'
            });
        }

        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
            // Initialize Select2 after modal is shown
            setTimeout(initializeSelect2Create, 100);
        }

        function closeCreateModal() {
            // Destroy Select2 before closing
            $('#siswa_id_create').select2('destroy');
            document.getElementById('createModal').classList.add('hidden');
        }

        function openEditModal(nilai) {
            document.getElementById('editForm').action = `/guru/mapels/{{ $mapel->id }}/nilais/${nilai.id}`;
            document.getElementById('edit_tanggal').value = nilai.tanggal.split('T')[0];
            document.getElementById('edit_keterangan').value = nilai.keterangan;
            document.getElementById('edit_nilai').value = nilai.nilai;
            document.getElementById('editModal').classList.remove('hidden');

            // Initialize Select2 and set value after modal is shown
            setTimeout(function() {
                initializeSelect2Edit();
                $('#edit_siswa_id').val(nilai.siswa_id).trigger('change');
            }, 100);
        }

        function closeEditModal() {
            // Destroy Select2 before closing
            $('#edit_siswa_id').select2('destroy');
            document.getElementById('editModal').classList.add('hidden');
        }

        window.onclick = function(event) {
            const createModal = document.getElementById('createModal');
            const editModal = document.getElementById('editModal');
            if (event.target == createModal) closeCreateModal();
            if (event.target == editModal) closeEditModal();
        }
    </script>
</x-app-layout>
