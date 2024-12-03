<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuarios
        $users = [
            [
                'name' => 'Administrador',
                'email' => 'admin@example.com',
                'role'  => 'administrador',
            ],
            [
                'name' => 'Autor',
                'email' => 'autor@example.com',
                'role'  => 'autor',
            ],
            [
                'name' => 'Revisor',
                'email' => 'revisor@example.com',
                'role'  => 'revisor',
            ],
            [
                'name' => 'Editor',
                'email' => 'editor@example.com',
                'role'  => 'editor',
            ]
        ];

        foreach ($users as $user) {
            $userCreated = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => bcrypt('password'),
            ]);

            $userCreated->assignRole($user['role']);
        }
    }
}
