<?php

namespace Database\Seeders;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin Desa',
            'email' => 'admin@desa.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $warga = User::create([
            'name' => 'Siti Warga',
            'email' => 'warga@desa.id',
            'password' => Hash::make('warga123'),
            'role' => 'warga',
            'dusun' => 'Dusun Melati',
        ]);

        Complaint::create([
            'user_id' => $warga->id,
            'category' => 'Jalan Rusak',
            'location' => 'Dusun Melati',
            'description' => 'Jalan berlubang dan sulit dilalui saat hujan.',
            'status' => 'Diproses',
            'admin_note' => 'Sudah dijadwalkan perbaikan minggu depan.',
        ]);
    }
}
