<?php

namespace Database\Seeders;

use App\Models\BookYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $years = ['0000', '2025', '2026', '2027'];
        foreach ($years as $year) {
            BookYear::firstOrCreate(['name' => $year]);
        }
    }
}
