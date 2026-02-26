<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin; // Ini sudah cukup untuk memanggil Model
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Super Admin
        Admin::create([
            'name'     => 'Super Admin',
            'email'    => 'super@gmail.com',
            'password' => Hash::make('12345678'),
            'role'     => 'superadmin',
        ]);

        // Akun Kadis (Hapus "App\Models\" karena sudah ada "use" di atas)
        Admin::create([
            'name'     => 'Kepala Dinas',
            'email'    => 'kadis@gmail.com',
            'password' => Hash::make('qwertyui'),
            'role'     => 'kadis', 
        ]);
    }
}