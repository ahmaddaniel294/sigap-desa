<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Complaint::CATEGORIES as $category) {
            Category::firstOrCreate(['name' => $category]);
        }

        $admin = User::whereIn('email', ['admin@lifecare.test', 'admin@lifemedia.test'])->first() ?? new User();
        $admin->fill([
            'name' => 'Admin Lifemedia',
            'email' => 'admin@lifemedia.test',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ])->save();

        $pelanggan = User::whereIn('email', ['pelanggan@lifecare.test'])->first() ?? new User();
        $pelanggan->fill([
            'name' => 'Pelanggan Demo',
            'email' => 'pelanggan@lifecare.test',
            'password' => Hash::make('pelanggan123'),
            'role' => 'warga',
            'dusun' => 'Jl. Merdeka No. 10',
        ])->save();

        $teknisi = User::where('email', 'teknisi@lifemedia.test')->first() ?? new User();
        $teknisi->fill([
            'name' => 'Teknisi Lifemedia',
            'email' => 'teknisi@lifemedia.test',
            'password' => Hash::make('teknisi123'),
            'role' => 'teknisi',
        ])->save();

        $complaint = Complaint::where('user_id', $pelanggan->id)->first() ?? new Complaint();
        $complaint->fill([
            'user_id' => $pelanggan->id,
            'technician_id' => $teknisi->id,
            'category' => 'Wi-Fi Lambat',
            'location' => 'Jl. Merdeka No. 10',
            'description' => 'Koneksi Wi-Fi terasa lambat sejak pagi dan mengganggu aktivitas online.',
            'status' => 'Diproses',
            'admin_note' => 'Pengaduan diterima. Tim Lifemedia sedang memeriksa koneksi di area pelanggan.',
            'technician_note' => 'Pemeriksaan awal sedang dilakukan pada kualitas sinyal dan perangkat router.',
        ])->save();
    }
}
