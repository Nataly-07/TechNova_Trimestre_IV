<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuarios de prueba
        $users = [
            [
                'name' => 'María González',
                'email' => 'maria.gonzalez@technova.com',
                'first_name' => 'María',
                'last_name' => 'González',
                'document_type' => 'CC',
                'document_number' => '12345678',
                'phone' => '3001234567',
                'address' => 'Calle 123 #45-67',
                'password' => Hash::make('password123'),
                'role' => 'cliente',
            ],
            [
                'name' => 'Carlos Rodríguez',
                'email' => 'carlos.rodriguez@technova.com',
                'first_name' => 'Carlos',
                'last_name' => 'Rodríguez',
                'document_type' => 'CC',
                'document_number' => '87654321',
                'phone' => '3007654321',
                'address' => 'Carrera 45 #78-90',
                'password' => Hash::make('password123'),
                'role' => 'empleado',
            ],
            [
                'name' => 'Ana Martínez',
                'email' => 'ana.martinez@technova.com',
                'first_name' => 'Ana',
                'last_name' => 'Martínez',
                'document_type' => 'CC',
                'document_number' => '11223344',
                'phone' => '3009876543',
                'address' => 'Avenida 80 #12-34',
                'password' => Hash::make('password123'),
                'role' => 'cliente',
            ],
            [
                'name' => 'Luis Pérez',
                'email' => 'luis.perez@technova.com',
                'first_name' => 'Luis',
                'last_name' => 'Pérez',
                'document_type' => 'CC',
                'document_number' => '55667788',
                'phone' => '3005555555',
                'address' => 'Calle 50 #90-12',
                'password' => Hash::make('password123'),
                'role' => 'empleado',
            ]
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
