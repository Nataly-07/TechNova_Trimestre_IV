<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@technova.com'],
            [
                'name' => 'Admin Technova',
                'first_name' => 'Admin',
                'last_name' => 'Technova',
                'document_type' => 'N/A',
                'document_number' => 'N/A',
                'phone' => '0000000000',
                'address' => 'N/A',
                'password' => Hash::make('Admin1234!'),
                'role' => 'admin',
            ]
        );
    }
}
