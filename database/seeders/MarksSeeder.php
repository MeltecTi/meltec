<?php

namespace Database\Seeders;

use App\Models\Mark;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mark::create([
            'name' => 'Motorola',
            'info' => 'Motorola Solutions se centra en proporcionar productos y servicios de comunicación de misión crítica para clientes en sectores como seguridad pública, servicios de emergencia, industria, transporte y energía. Su cartera de productos incluye radios de dos vías, sistemas de comunicación avanzados, dispositivos móviles y aplicaciones de software especializadas.'
        ]);

        Mark::create([
            'name' => 'Huawei',
            'info' => 'Huawei ofrece una amplia gama de soluciones y servicios para operadores de telecomunicaciones y proveedores de servicios de Internet. Esto incluye equipos de red, como routers y conmutadores, así como soluciones de software para la gestión eficiente de la red y la entrega de servicios.'
        ]);

        Mark::create([
            'name' => 'Zebra',
            'info' => 'Zebra es el desarrollo de soluciones de identificación automática y captura de datos (AIDC, por sus siglas en inglés). Esto incluye tecnologías como impresoras de códigos de barras, escáneres, computadoras móviles, etiquetas y sistemas de gestión de inventario. Estas soluciones permiten a las empresas rastrear y administrar activos, optimizar la cadena de suministro, mejorar la precisión del inventario y aumentar la visibilidad en tiempo real.'
        ]);
    }
}
