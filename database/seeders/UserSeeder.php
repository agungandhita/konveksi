<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin Konveksi',
            'email' => 'admin@konveksi.com',
            'phone' => '081234567890',
            'address' => 'Jl. Admin No. 1, Jakarta',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create Sample Users
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '081234567891',
            'address' => 'Jl. Contoh No. 2, Bandung',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '081234567892',
            'address' => 'Jl. Sample No. 3, Surabaya',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Bob Wilson',
            'email' => 'bob@example.com',
            'phone' => '081234567893',
            'address' => 'Jl. Demo No. 4, Medan',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Alice Johnson',
            'email' => 'alice@example.com',
            'phone' => '081234567894',
            'address' => 'Jl. Test No. 5, Yogyakarta',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
}
}
