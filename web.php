<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{DashboardController as AdminDashboard, UserController};
use App\Http\Controllers\Guru\DashboardController as GuruDashboard;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes untuk semua user (guru & siswa bisa edit profile sendiri)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'checkrole:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('mapels', \App\Http\Controllers\Admin\MapelController::class);
    Route::get('/guru-mapel', [\App\Http\Controllers\Admin\GuruMapelController::class, 'index'])->name('guru-mapel.index');
    Route::post('/guru-mapel/assign', [\App\Http\Controllers\Admin\GuruMapelController::class, 'assign'])->name('guru-mapel.assign');
    Route::post('/guru-mapel/toggle', [\App\Http\Controllers\Admin\GuruMapelController::class, 'toggle'])->name('guru-mapel.toggle');
});

Route::middleware(['auth', 'checkrole:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruDashboard::class, 'index'])->name('dashboard');
    Route::get('/mapels', [\App\Http\Controllers\Guru\MapelController::class, 'index'])->name('mapels.index');
    Route::get('/mapels/{mapel}/nilais', [\App\Http\Controllers\Guru\NilaiController::class, 'index'])->name('nilais.index');
    Route::post('/mapels/{mapel}/nilais', [\App\Http\Controllers\Guru\NilaiController::class, 'store'])->name('nilais.store');
    Route::put('/mapels/{mapel}/nilais/{nilai}', [\App\Http\Controllers\Guru\NilaiController::class, 'update'])->name('nilais.update');
    Route::delete('/mapels/{mapel}/nilais/{nilai}', [\App\Http\Controllers\Guru\NilaiController::class, 'destroy'])->name('nilais.destroy');
});

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

require __DIR__.'/auth.php';
