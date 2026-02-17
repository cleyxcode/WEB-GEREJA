<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@gerejabethesda.com'], [
            'name' => 'Administrator', 'password' => Hash::make('Admin@1234'),
            'role' => 'admin', 'no_hp' => '081200000001',
            'alamat' => 'Gereja Bethesda, Jl. Harapan Indah No. 123, Jakarta Pusat',
        ]);

        $jemaat = [
            ['name' => 'Budi Santoso',       'email' => 'budi@email.com',   'no_hp' => '081234567890', 'alamat' => 'Jl. Mawar No. 45, Jakarta Selatan'],
            ['name' => 'Sari Widya Ningrum', 'email' => 'sari@email.com',   'no_hp' => '082345678901', 'alamat' => 'Jl. Merpati No. 12, Tangerang'],
            ['name' => 'Hendra Kusuma',      'email' => 'hendra@email.com', 'no_hp' => '083456789012', 'alamat' => 'Jl. Kenanga No. 7, Bekasi'],
            ['name' => 'Dewi Lestari',       'email' => 'dewi@email.com',   'no_hp' => '084567890123', 'alamat' => 'Jl. Melati No. 3, Depok'],
            ['name' => 'Agus Prasetyo',      'email' => 'agus@email.com',   'no_hp' => '085678901234', 'alamat' => 'Jl. Anggrek No. 22, Bogor'],
        ];

        foreach ($jemaat as $data) {
            User::updateOrCreate(['email' => $data['email']], [
                'name' => $data['name'], 'password' => Hash::make('password123'),
                'role' => 'jemaat', 'no_hp' => $data['no_hp'], 'alamat' => $data['alamat'],
            ]);
        }

        $this->command->info('✅ UserSeeder: 1 admin + 5 jemaat selesai.');
    }
}