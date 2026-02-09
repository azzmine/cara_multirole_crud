<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah User Baru</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 bg-gradient-to-r from-blue-500 to-blue-600 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-white">Form Tambah User</h3>
                    <p class="text-sm text-blue-100 mt-1">Lengkapi data user baru di bawah ini</p>
                </div>

                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf

                    <!-- Photo Upload -->
                    <div class="mb-6 flex justify-center">
                        <div class="text-center">
                            <div class="mb-3">
                                <div id="preview-container" class="hidden">
                                    <img id="photo-preview" class="w-32 h-32 rounded-full object-cover border-4 border-blue-500 shadow-lg mx-auto">
                                </div>
                                <div id="placeholder-avatar" class="w-32 h-32 rounded-full bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center text-4xl text-white font-bold shadow-lg mx-auto">
                                    <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            <label for="photo" class="cursor-pointer inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Upload Foto
                            </label>
                            <input type="file" id="photo" name="photo" accept="image/*" class="hidden">
                            <p class="text-xs text-gray-500 mt-2">JPG, PNG maksimal 2MB</p>
                            @error('photo')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="Masukkan nama lengkap" required>
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="nama@example.com" required>
                            @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="Minimal 8 karakter" required>
                            @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Role <span class="text-red-500">*</span>
                            </label>
                            <select name="role_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
                                <option value="">Pilih Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Gender -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                            <select name="gender" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">No. HP</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                maxlength="15"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15)"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="08xxxxxxxxxx">
                            <p class="text-xs text-gray-500 mt-1">Maksimal 15 digit angka</p>
                            @error('phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Birth Place -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir</label>
                            <input type="text" name="birth_place" value="{{ old('birth_place') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="Jakarta">
                            @error('birth_place')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Birth Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                            <input type="date" name="birth_date" value="{{ old('birth_date') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('birth_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                        <textarea name="address" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Jl. Contoh No. 123, Kelurahan, Kecamatan, Kota">{{ old('address') }}</textarea>
                        @error('address')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.users.index') }}"
                            class="inline-flex items-center px-6 py-2 bg-gray-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Preview foto saat dipilih
        document.getElementById('photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photo-preview').src = e.target.result;
                    document.getElementById('preview-container').classList.remove('hidden');
                    document.getElementById('placeholder-avatar').classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>
