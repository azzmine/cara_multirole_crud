<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Insert roles
        DB::table('roles')->insert([
            ['name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'guru', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'siswa', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Insert users
        DB::table('users')->insert([
            ['name' => 'Admin', 'email' => 'admin@gmail.com', 'password' => Hash::make('password'), 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Guru', 'email' => 'guru@gmail.com', 'password' => Hash::make('password'), 'role_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Siswa', 'email' => 'siswa@gmail.com', 'password' => Hash::make('password'), 'role_id' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
