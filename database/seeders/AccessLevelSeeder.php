<?php

namespace Database\Seeders;

use App\Models\AccessLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccessLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accessLevels = ['admin', 'familie lid'];
        foreach ($accessLevels as $accessLevel) {
            AccessLevel::firstOrCreate(['name' => $accessLevel]);
        }
    }
}
