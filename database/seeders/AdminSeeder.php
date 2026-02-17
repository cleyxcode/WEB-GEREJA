<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gerejabethesda.com'],
            [
                'name'     => 'Administrator',
                'email'    => 'admin@gerejabethesda.com',
                'password' => Hash::make('Admin@1234'),
                'role'     => 'admin',
                'no_hp'    => '081234567890',
                'alamat'   => 'Gereja Bethesda, Jl. Harapan Indah No. 123, Jakarta Pusat',
            ]
        );

        $this->command->info('✅ Admin default berhasil dibuat!');
        $this->command->info('📧 Email    : admin@gerejabethesda.com');
        $this->command->info('🔑 Password : Admin@1234');
    }
}