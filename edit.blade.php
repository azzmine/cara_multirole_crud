<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit User</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 bg-gradient-to-r from-green-500 to-green-600 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-white">Form Edit User</h3>
                    <p class="text-sm text-green-100 mt-1">Update data user: <strong>{{ $user->name }}</strong></p>
                </div>

                <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf @method('PUT')

                    <!-- Current Photo Preview -->
                    <div class="mb-6 flex justify-center">
                        <div class="text-center">
                            <div class="mb-3">
                                @if($user->photo)
                                    <img id="photo-preview" src="{{ asset('storage/' . $user->photo) }}" class="w-32 h-32 rounded-full object-cover border-4 border-green-500 shadow-lg mx-auto">
                                @else
                                    <div id="photo-preview" class="w-32 h-32 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-4xl text-white font-bold shadow-lg mx-auto">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <label for="photo" class="cursor-pointer inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                Ubah Foto
                            </label>
                            <input type="file" id="photo" name="photo" accept="image/*" class="hidden">
                            <p class="text-xs text-gray-500 mt-2">JPG, PNG maksimal 2MB (kosongkan jika tidak diubah)</p>
                            @error('photo')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition" required>
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition" required>
                            @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Password <span class="text-gray-400">(kosongkan jika tidak diubah)</span>
                            </label>
                            <input type="password" name="password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                placeholder="Minimal 8 karakter">
                            @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Role <span class="text-red-500">*</span>
                            </label>
                            <select name="role_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Gender -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                            <select name="gender" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">No. HP</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                maxlength="15"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15)"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                placeholder="08xxxxxxxxxx">
                            <p class="text-xs text-gray-500 mt-1">Maksimal 15 digit angka</p>
                            @error('phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Birth Place -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir</label>
                            <input type="text" name="birth_place" value="{{ old('birth_place', $user->birth_place) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                placeholder="Jakarta">
                            @error('birth_place')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Birth Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                            <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                            @error('birth_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                        <textarea name="address" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                            placeholder="Jl. Contoh No. 123, Kelurahan, Kecamatan, Kota">{{ old('address', $user->address) }}</textarea>
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
                            class="inline-flex items-center px-6 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update User
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
                    const preview = document.getElementById('photo-preview');
                    preview.src = e.target.result;
                    preview.className = 'w-32 h-32 rounded-full object-cover border-4 border-green-500 shadow-lg mx-auto';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>
