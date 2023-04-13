<?php

namespace Database\Seeders;

use App\Models\User;
use App\Permissons;
use App\Rols;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Rols::create([
            'name' => 'SuperAdministrador',
        ]);

        $permissions = Permissons::all();
        $role->syncPermissions($permissions);

        $user =  User::create([
            'name' => 'Nicolas Cuadros',
            'email' => 'admin@meltec.com.co',
            'password' => bcrypt('123456789'),
            'image' => '1234',
        ]);

        $user->assingRole($role);
    }
}
