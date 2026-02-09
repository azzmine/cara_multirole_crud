<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail User</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-6">
                            @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}"
                                    class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-xl">
                            @else
                                <div class="w-28 h-28 rounded-full bg-white flex items-center justify-center text-4xl text-indigo-600 font-bold shadow-xl border-4 border-white">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <h3 class="text-3xl font-bold text-white">{{ $user->name }}</h3>
                                <p class="text-indigo-100 mt-1 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $user->email }}
                                </p>
                                <div class="mt-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                        {{ $user->role->name === 'admin' ? 'bg-purple-200 text-purple-800' : '' }}
                                        {{ $user->role->name === 'guru' ? 'bg-green-200 text-green-800' : '' }}
                                        {{ $user->role->name === 'siswa' ? 'bg-blue-200 text-blue-800' : '' }}
                                    ">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        {{ ucfirst($user->role->name) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('admin.users.edit', $user) }}"
                                class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 rounded-lg font-semibold text-sm hover:bg-indigo-50 transition shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit User
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="p-8">
                    <h4 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Lengkap
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- ID -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">ID User</label>
                            <p class="text-gray-900 font-medium">#{{ $user->id }}</p>
                        </div>

                        <!-- Nama -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                            <p class="text-gray-900 font-medium">{{ $user->name }}</p>
                        </div>

                        <!-- Email -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Email</label>
                            <p class="text-gray-900 font-medium">{{ $user->email }}</p>
                        </div>

                        <!-- Role -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Role</label>
                            <p class="text-gray-900 font-medium">{{ ucfirst($user->role->name) }}</p>
                        </div>

                        <!-- Gender -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Jenis Kelamin</label>
                            <p class="text-gray-900 font-medium">
                                {{ $user->gender ? ($user->gender === 'male' ? 'Laki-laki' : 'Perempuan') : '-' }}
                            </p>
                        </div>

                        <!-- Phone -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">No. HP</label>
                            <p class="text-gray-900 font-medium">{{ $user->phone ?? '-' }}</p>
                        </div>

                        <!-- Birth Place -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Tempat Lahir</label>
                            <p class="text-gray-900 font-medium">{{ $user->birth_place ?? '-' }}</p>
                        </div>

                        <!-- Birth Date -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Tanggal Lahir</label>
                            <p class="text-gray-900 font-medium">{{ $user->birth_date ? $user->birth_date->format('d F Y') : '-' }}</p>
                        </div>

                        <!-- Created At -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Dibuat Pada</label>
                            <p class="text-gray-900 font-medium">{{ $user->created_at->format('d F Y, H:i') }}</p>
                        </div>

                        <!-- Updated At -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Terakhir Diubah</label>
                            <p class="text-gray-900 font-medium">{{ $user->updated_at->format('d F Y, H:i') }}</p>
                        </div>
                    </div>

                    <!-- Address (Full Width) -->
                    @if($user->address)
                    <div class="mt-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Alamat Lengkap</label>
                        <p class="text-gray-900 font-medium leading-relaxed">{{ $user->address }}</p>
                    </div>
                    @endif
                </div>

                <!-- Footer Actions -->
                <div class="bg-gray-50 px-8 py-4 border-t border-gray-200 flex justify-between items-center">
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                    <div class="text-sm text-gray-500">
                        ID: <span class="font-semibold text-gray-700">#{{ $user->id }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
