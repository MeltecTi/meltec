<?php

namespace Database\Seeders;

use App\Models\BaseWeb;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BaseWebSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BaseWeb::create([
            'component' => 'facebook',
            'content' => '<p>https://www.facebook.com/search/top?q=meltec</p>',
            'type_component' => 'url',
        ]);

        BaseWeb::create([
            'component' => 'instagram',
            'content' => '<p>https://www.instagram.com/meltec_comunicaciones/</p>',
            'type_component' => 'url',
        ]);

        BaseWeb::create([
            'component' => 'youtube',
            'content' => '<p>https://www.youtube.com/channel/UC6ZOgVpdTSbiG9KyckRr5yA</p>',
            'type_component' => 'url',
        ]);

        BaseWeb::create([
            'component' => 'linkedin',
            'content' => '<p>https://co.linkedin.com/company/meltec</p>',
            'type_component' => 'url',
        ]);

        BaseWeb::create([
            'component' => 'twitter',
            'content' => '<p>https://twitter.com/MeltecCom</p>',
            'type_component' => 'url',
        ]);
        
    }
}
