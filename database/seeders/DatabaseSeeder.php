<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roleAdmin = Role::create(['name' => 'administrador']);
        $roleAnalista = Role::create(['name' => 'Comercial']);

        \App\Models\States::factory()->create([
            'name' => 'Activo',
        ]);
        \App\Models\States::factory()->create([
            'name' => 'Inactivo',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Sebastián',
            'lastname' => 'Chaparro',
            'idState' => 1,
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
        ])->assignRole('administrador');

        \App\Models\User::factory()->create([
            'name' => 'Daniel',
            'lastname' => 'Aguilar',
            'idState' => 1,
            'email' => 'daniel.aguilar@kolondoo.com',
            'password' => bcrypt('12345'),
        ]);

        $permisos = [
            
        ];

        $rol = 'administrador';

        foreach ($permisos as $nombrePermiso) {
            if ($nombrePermiso) {
                Permission::create(['name' => $nombrePermiso])->assignRole($rol);
            }
        }
    }
}
