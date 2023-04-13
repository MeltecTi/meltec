<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SeederTablaPermisosMenu extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [

            //Tabla Menus
            'ver-pagina',
            'crear-pagina',
            'editar-pagina',
            'borrar-pagina',
        ];

        foreach($permisos as $permiso) {
            Permission::create(['name' =>$permiso]);
        }
    }
}
