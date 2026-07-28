<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Persons extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Teacher::updateOrCreate([
            'id' => 1,
            'name' => 'Gilmar Bosso',
            'email' => 'mazinhobosso@gmail.com',
            'role' => 'admin',
            'status' => 'approved',
            'term_privacy' => true,
            'apresentation' => 'Usuário interessado em cursos de tecnologia e programação.',
            'password' => Hash::make('senha1234'),
        ]);
    }
}
