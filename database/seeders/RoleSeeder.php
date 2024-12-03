<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos
        $permissions = [
            'create',
            'edit',
            'submit',
            'review',
            'approve',
            'reject',
            'publish',
            'unpublish'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        // Crear roles y asignar permisos
        $autor = Role::create(['name' => 'autor']);
        $autor->givePermissionTo(['create', 'edit', 'submit']);
        $revisor = Role::create(['name' => 'revisor']);
        $revisor->givePermissionTo(['review', 'approve', 'reject']);
        $editor = Role::create(['name' => 'editor']);
        $editor->givePermissionTo(['publish', 'unpublish']);
        $admin = Role::create(['name' => 'administrador']);
        $admin->givePermissionTo(Permission::all());
    }
}
