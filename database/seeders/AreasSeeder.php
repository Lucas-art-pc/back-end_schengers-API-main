<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            [
                'name_area'  => 'Programação',
                'color_area' => '#1E40AF',
            ],
            [
                'name_area'  => 'Design',
                'color_area' => '#FCAC21',
            ],
            [
                'name_area'  => 'Marketing Digital',
                'color_area' => '#0B2373',

            ],
            [
                'name_area'  => 'Banco de Dados',
                'color_area' => '#D68906',

            ],
            [
                'name_area'  => 'Segurança da Informação',
                'color_area' => '#94A3B8',

            ],
        ];

        foreach ($areas as $area) {
            Area::updateOrCreate(
                ['slug_area' => Str::slug($area['name_area'])],
                [
                    'name_area'  => $area['name_area'],
                    'slug_area'  => Str::slug($area['name_area']),
                    'color_area' => $area['color_area'],
                ]
            );
        }
    }
}
