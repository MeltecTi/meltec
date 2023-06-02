<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Template::create([
            'templateName' => 'Pagina de Marca',
            'routeTemplate' => 'layouts.pagesLayouts.markLayout',
        ]);

        Template::create([
            'templateName' => 'Pagina de Contacto',
            'routeTemplate' => 'layouts.pagesLayouts.contactLayout'
        ]);

        Template::create([
            'templateName' => 'Pagina de Soluciones',
            'routeTemplate' => 'layouts.pagesLayouts.solutionsLayout'
        ]);

        Template::create([
            'templateName' => 'Pagina de Casos de Exito',
            'routeTemplate' => 'layouts.pagesLayouts.successCaseLayout'
        ]);

        Template::create([
            'templateName' => 'Pagina Normal',
            'routeTemplate' => 'page'
        ]);
    }
}
