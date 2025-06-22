<?php

namespace Database\Seeders;

use App\Models\AgeDiscount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgeDiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ageDiscounts = [
            ['name' => 'personeel', 'min_age' => 16, 'max_age' => 200, 'discount_percentage' => 0],
            ['name' => 'jeugd', 'min_age' => 0, 'max_age' => 7, 'discount_percentage' => 50],
            ['name' => 'aspirant', 'min_age' => 8, 'max_age' => 12, 'discount_percentage' => 40],
            ['name' => 'junior', 'min_age' => 13, 'max_age' => 17, 'discount_percentage' => 25],
            ['name' => 'senior', 'min_age' => 18, 'max_age' => 50, 'discount_percentage' => 0],
            ['name' => 'oudere', 'min_age' => 51, 'max_age' => 200, 'discount_percentage' => 45]
        ];

        foreach ($ageDiscounts as $ageDiscount) {
            AgeDiscount::create($ageDiscount);
        }
    }
}
