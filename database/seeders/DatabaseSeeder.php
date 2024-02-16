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
            'email' => 'mauricio@chaparro.com',
            'password' => bcrypt('12345'),
        ]);

    }
}
