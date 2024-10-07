<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Levels;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Levels::create([
            'name' => 'Level 01',
            'rate' => 10
        ]);
        Levels::create([
            'name' => 'Level 02',
            'rate' => 5
        ]);
        Levels::create([
            'name' => 'Level 03',
            'rate' => 3
        ]);
        Levels::create([
            'name' => 'Level 04',
            'rate' => 2
        ]);
        Levels::create([
            'name' => 'Level 05',
            'rate' => 1
        ]);
    }
}
