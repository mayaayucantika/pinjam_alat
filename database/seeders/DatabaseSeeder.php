<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@pinjamku.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Create Petugas
        User::create([
            'name' => 'Petugas',
            'email' => 'petugas@pinjamku.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
            'status' => 'active',
        ]);

        // Create 3 dummy users
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'peminjam',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'role' => 'peminjam',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Ahmad Fauzi',
            'email' => 'ahmad@example.com',
            'password' => Hash::make('password'),
            'role' => 'peminjam',
            'status' => 'active',
        ]);

        // Seed categories and tools
        $this->call([
            CategorySeeder::class,
            ToolSeeder::class,
        ]);
    }
}
