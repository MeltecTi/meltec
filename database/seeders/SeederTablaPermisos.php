<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

//Spatie

class SeederTablaPermisos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            // // Tabla Roles
            // 'ver-rol',
            // 'crear-rol',
            // 'editar-rol',
            // 'borrar-rol',

            // //Tabla Blogs
            // 'ver-blog',
            // 'crear-blog',
            // 'editar-blog',
            // 'borrar-blog',

            //Tabla Categorias
            // 'ver-categoria',
            // 'crear-categoria',
            // 'editar-categoria',
            // 'borrar-categoria',

            //Tabla Usuarios
            // 'crear-usuarios',
            // 'editar-usuarios',
            // 'borrar-usuarios',
            'ver-todos-los-usuarios'
        ];

        foreach($permisos as $permiso) {
            Permission::create(['name' =>$permiso]);
        }
    }
}
