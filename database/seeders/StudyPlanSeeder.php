<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudyPlanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tb_study_plans')->insert([
            [
                'fk_id_student' => 1,
                'day_of_week_study_plan' => 'Segunda-feira',
                'activity_study_plan' => 'Estudo de HTML e CSS',
                'description_study_plan' => 'Revisar conceitos básicos e praticar layout responsivo',
                'duration_study_plan' => 120,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fk_id_student' => 1,
                'day_of_week_study_plan' => 'Terça-feira',
                'activity_study_plan' => 'JavaScript',
                'description_study_plan' => 'Funções, arrays e manipulação de DOM',
                'duration_study_plan' => 150,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fk_id_student' => 1,
                'day_of_week_study_plan' => 'Quarta-feira',
                'activity_study_plan' => 'React',
                'description_study_plan' => 'Componentes, props e useState',
                'duration_study_plan' => 180,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fk_id_student' => 1,
                'day_of_week_study_plan' => 'Quinta-feira',
                'activity_study_plan' => 'Banco de Dados',
                'description_study_plan' => 'Praticar queries com JOIN',
                'duration_study_plan' => 120,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fk_id_student' => 1,
                'day_of_week_study_plan' => 'Sexta-feira',
                'activity_study_plan' => 'Laravel',
                'description_study_plan' => 'Criar APIs e trabalhar com migrations',
                'duration_study_plan' => 150,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
