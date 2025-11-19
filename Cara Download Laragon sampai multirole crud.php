Cara Download Laragon sampai install breeze
========================================================

download laragon 6.0 dari website
download zip php 8.4 atau lebih
buat folder baru untuk php 8.4 di \laragon\bin\php
extract zip php ke folder baru yg sudah di buat didalam \laragon\bin\php
ke laragon, ganti versi php dgn versi 8.4 yang sudah di extract
masuk ke terminal dari laragon
pastikan nodejs sudah v18+
composer create-project laravel/laravel nama_project
cd nama_project
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run dev (buka terminal baru)
php artisan serve (terminal terpisah)


Cara Membuat Database dan Multi Role
===============================================

1. Setup Database SQLite
---
cek extention sqlite dgn code "php -m | findstr /i sqlite"
jika belum aktif buka php.ini, aktifkan extension=sqlite3, restart server PHP, jika sudah aktif bisa langsung membuat database
type nul > database\database.sqlite
Edit .env:
  DB_CONNECTION=sqlite
  DB_DATABASE=C:\laragon\www\namaproject\database\database.sqlite
php artisan config:clear


2. Buat Role Model & Migration
---
php artisan make:model Role -m

database/migrations/xxxx_create_roles_table.php:
public function up(): void
{
    Schema::create('roles', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique();
        $table->timestamps();
    });
}

public function down(): void
    {
        Schema::dropIfExists('roles');
    }

app/Models/Role.php:
protected $fillable = ['name'];
public function users() {
    return $this->hasMany(User::class);
}


3. Tambah role_id ke Users
---
php artisan make:migration add_role_id_to_users --table=users

database/migrations/xxxx_add_role_id_to_users.php:
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->foreignId('role_id')->nullable()->constrained()->onDelete('set null');
    });
}

app/Models/User.php (tambahkan):
protected $fillable = ['name', 'email', 'password', 'role_id'];

public function role() {
    return $this->belongsTo(Role::class);
}


4. Buat Seeders
---
php artisan make:seeder RoleSeeder
php artisan make:seeder UserSeeder

database/seeders/RoleSeeder.php:
use App\Models\Role;

public function run(): void
{
    Role::insert([
        ['name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'guru', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'siswa', 'created_at' => now(), 'updated_at' => now()],
    ]);
}

database/seeders/UserSeeder.php:
use App\Models\{User, Role};
use Illuminate\Support\Facades\Hash;

public function run(): void
{
        $adminRole = Role::where('name', 'admin')->first();
        $guruRole = Role::where('name', 'guru')->first();
        $siswaRole = Role::where('name', 'siswa')->first();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'name' => 'Guru',
            'email' => 'guru@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => $guruRole->id,
        ]);

        User::create([
            'name' => 'Siswa',
            'email' => 'siswa@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => $siswaRole->id,
        ]);
}

database/seeders/DatabaseSeeder.php: (hapus/ komen "//" bagian user factory)
public function run(): void
{
    $this->call([
        RoleSeeder::class,
        UserSeeder::class,
    ]);
}


5. Buat Middleware CheckRole
---
php artisan make:middleware CheckRole

app/Http/Middleware/CheckRole.php:
use Illuminate\Support\Facades\Auth;

    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Cek apakah user punya relasi role
        if (!Auth::user()->role) {
            Auth::logout();
            return redirect('/login')->with('error', 'User tidak memiliki role');
        }

        // Cek apakah role sesuai
        if (Auth::user()->role->name !== $role) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }

bootstrap/app.php (tambahkan di ->withMiddleware):
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'checkrole' => \App\Http\Middleware\CheckRole::class,
    ]);
})


6. Buat Controllers
---
php artisan make:controller Admin/DashboardController
php artisan make:controller Admin/UserController --resource
php artisan make:controller Guru/DashboardController
php artisan make:controller Siswa/DashboardController

app/Http/Controllers/Admin/DashboardController.php:
public function index() {
    return view('admin.dashboard');
}

app/Http/Controllers/Admin/UserController.php:
use App\Models\{User, Role};
use Illuminate\Support\Facades\Hash;

public function index() {
    $users = User::with('role')->latest()->paginate(10);
    return view('admin.users.index', compact('users'));
}

public function create() {
    $roles = Role::all();
    return view('admin.users.create', compact('roles'));
}

public function store(Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
        'role_id' => 'required|exists:roles,id',
    ]);
    
    $validated['password'] = Hash::make($validated['password']);
    User::create($validated);
    
    return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan');
}

public function edit(User $user) {
    $roles = Role::all();
    return view('admin.users.edit', compact('user', 'roles'));
}

public function update(Request $request, User $user) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,'.$user->id,
        'role_id' => 'required|exists:roles,id',
    ]);
    
    if ($request->filled('password')) {
        $validated['password'] = Hash::make($request->password);
    }
    
    $user->update($validated);
    return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate');
}

public function destroy(User $user) {
    $user->delete();
    return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
}

app/Http/Controllers/Guru/DashboardController.php:
public function index() {
    return view('guru.dashboard');
}

app/Http/Controllers/Siswa/DashboardController.php:
public function index() {
    return view('siswa.dashboard');
}


7. Routes
---
routes/web.php:
use App\Http\Controllers\Admin\{DashboardController as AdminDashboard, UserController};
use App\Http\Controllers\Guru\DashboardController as GuruDashboard;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;
use Illuminate\Support\Facades\Auth;

Route::middleware(['auth', 'checkrole:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
});

Route::get('/guru/dashboard', [GuruDashboard::class, 'index'])
    ->middleware(['auth', 'checkrole:guru'])->name('guru.dashboard');

Route::get('/siswa/dashboard', [SiswaDashboard::class, 'index'])
    ->middleware(['auth', 'checkrole:siswa'])->name('siswa.dashboard');

Route::get('/dashboard', function () {
    $role = Auth::user()->role->name;
    return match($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'guru' => redirect()->route('guru.dashboard'),
        'siswa' => redirect()->route('siswa.dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');


8. Buat Views
---
resources/views/admin/dashboard.blade.php:
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('admin.users.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Kelola Users
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

resources/views/admin/users/index.blade.php:
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Users</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <a href="{{ route('admin.users.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
                    Tambah User
                </a>

                <table class="min-w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left p-2">Nama</th>
                            <th class="text-left p-2">Email</th>
                            <th class="text-left p-2">Role</th>
                            <th class="text-left p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-b">
                            <td class="p-2">{{ $user->name }}</td>
                            <td class="p-2">{{ $user->email }}</td>
                            <td class="p-2">{{ $user->role->name }}</td>
                            <td class="p-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-500">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 ml-2" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">{{ $users->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>

resources/views/admin/users/create.blade.php:
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah User</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-2">Nama</label>
                        <input type="text" name="name" class="border rounded w-full p-2" required>
                        @error('name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Email</label>
                        <input type="email" name="email" class="border rounded w-full p-2" required>
                        @error('email')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Password</label>
                        <input type="password" name="password" class="border rounded w-full p-2" required>
                        @error('password')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Role</label>
                        <select name="role_id" class="border rounded w-full p-2" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                        @error('role_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                    <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

resources/views/admin/users/edit.blade.php:
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit User</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label class="block mb-2">Nama</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="border rounded w-full p-2" required>
                        @error('name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="border rounded w-full p-2" required>
                        @error('email')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Password (kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" class="border rounded w-full p-2">
                        @error('password')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Role</label>
                        <select name="role_id" class="border rounded w-full p-2" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                    <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

resources/views/guru/dashboard.blade.php:
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Guru Dashboard</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">Dashboard Guru</div>
            </div>
        </div>
    </div>
</x-app-layout>

resources/views/siswa/dashboard.blade.php:
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Siswa Dashboard</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">Dashboard Siswa</div>
            </div>
        </div>
    </div>
</x-app-layout>


9. Jalankan Migrasi & Seeder
---
php artisan migrate:fresh --seed


10. Testing
---
php artisan serve