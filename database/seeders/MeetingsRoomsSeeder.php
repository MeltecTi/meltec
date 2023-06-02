<?php

namespace Database\Seeders;

use App\Models\MeetingRoom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MeetingsRoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MeetingRoom::create([
           'room' => 'Sala AutoCapacitacion' ,
           'capacity' => '4',
           'location' => 'Edificio Meltec Bogota Piso 3'
        ]);

        MeetingRoom::create([
           'room' => 'Sala Cuidados Digitales' ,
           'capacity' => '8',
           'location' => 'Edificio Meltec Bogota Piso 3'
        ]);

        MeetingRoom::create([
           'room' => 'Sala Excelencia' ,
           'capacity' => '12',
           'location' => 'Edificio Meltec Bogota Piso 3, al lado de Gerencia general'
        ]);

        MeetingRoom::create([
           'room' => 'Sala Vision' ,
           'capacity' => '12',
           'location' => 'Edificio Meltec Bogota Piso 4'
        ]);

        MeetingRoom::create([
           'room' => 'Sala Trabajo en Equipo' ,
           'capacity' => '100',
           'location' => 'Edificio Meltec Bogota Piso 4, al frente de Cafeteria'
        ]);

        MeetingRoom::create([
           'room' => 'Sala Innovacion' ,
           'capacity' => '12',
           'location' => 'Edificio Meltec Bogota Piso 4, detras de Cafeteria'
        ]);
    }
}
