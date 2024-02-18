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
            'numberDocument' => '1022399551',
            'idState' => 1,
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
        ])->assignRole('administrador');

        \App\Models\User::factory()->create([
            'name' => 'Daniel',
            'lastname' => 'Aguilar',
            'numberDocument' => '12345',
            'idState' => 1,
            'email' => 'daniel.aguilar@kolondoo.com',
            'password' => bcrypt('12345'),
        ]);

        $permisos = [
            'clientes.view',
            'clientes.view.comercializadoras',
            'clientes.view.operadoras',
            'parrilas.view.energia',
            'parrilas.view.energia.view-gas',
            'parrilas.view.energia.view-luz',
            'parrilas.view.energia.view-luzygas',
            'parrilas.view.telefonia',
            'parrilas.view.telefonia.view-fibra',
            'parrilas.view.telefonia.view-fibramovil',
            'parrilas.view.telefonia.view-fibramoviltv',
            'parrilas.view.telefonia.view-movil',
            'permisos.view',
            'permisos.view.btn-create',
            'permisos.view.btn-edit',
            'roles.view',
            'roles.view.btn-create',
            'roles.view.btn-edit',
            'usuarios.view',
            'usuarios.view.btn-create',
            'usuarios.view.btn-edit'
        ];

        $rol = 'administrador';

        foreach ($permisos as $nombrePermiso) {
            if ($nombrePermiso) {
                Permission::create(['name' => $nombrePermiso])->assignRole($rol);
            }
        }
    }
}
