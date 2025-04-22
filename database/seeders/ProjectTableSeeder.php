<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::insert([
            ['name' => 'Weekly Report Project'],
            ['name' => 'Random Project 1'],
            ['name' => 'Local Project'],
            ['name' => 'Company Project'],
            ['name' => 'Random Project 2']
        ]   
        );
    }
}
