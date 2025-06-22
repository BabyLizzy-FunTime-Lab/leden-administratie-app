<?php

namespace Database\Seeders;

use App\Models\Contribution;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContributionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contributions = [
            ['name' => 'personeel', 'age_discount_id' => '1', 'membership_id' => '1', 'book_year_id' => '1', 'total_contribution_fee' => 0],

            ['name' => 'jeugd standaard 2025', 'age_discount_id' => '2', 'membership_id' => '2', 'book_year_id' => '2', 'total_contribution_fee' => 50],
            ['name' => 'jeugd erelid 2025', 'age_discount_id' => '2', 'membership_id' => '3', 'book_year_id' => '2', 'total_contribution_fee' => 40],
            ['name' => 'aspirant standaard 2025', 'age_discount_id' => '3', 'membership_id' => '2', 'book_year_id' => '2', 'total_contribution_fee' => 60],
            ['name' => 'aspirant erelid 2025', 'age_discount_id' => '3', 'membership_id' => '3', 'book_year_id' => '2', 'total_contribution_fee' => 50],
            ['name' => 'junior standaard 2025', 'age_discount_id' => '4', 'membership_id' => '2', 'book_year_id' => '2', 'total_contribution_fee' => 75],
            ['name' => 'junior erelid 2025', 'age_discount_id' => '4', 'membership_id' => '3', 'book_year_id' => '2', 'total_contribution_fee' => 65],
            ['name' => 'junior student 2025', 'age_discount_id' => '4', 'membership_id' => '4', 'book_year_id' => '2', 'total_contribution_fee' => 55],
            ['name' => 'senior standaard 2025', 'age_discount_id' => '5', 'membership_id' => '2', 'book_year_id' => '2', 'total_contribution_fee' => 100],
            ['name' => 'senior erelid 2025', 'age_discount_id' => '5', 'membership_id' => '3', 'book_year_id' => '2', 'total_contribution_fee' => 90],
            ['name' => 'senior student 2025', 'age_discount_id' => '5', 'membership_id' => '4', 'book_year_id' => '2', 'total_contribution_fee' => 80],
            ['name' => 'oudere standaard 2025', 'age_discount_id' => '6', 'membership_id' => '2', 'book_year_id' => '2', 'total_contribution_fee' => 55],
            ['name' => 'oudere student 2025', 'age_discount_id' => '6', 'membership_id' => '4', 'book_year_id' => '2', 'total_contribution_fee' => 35],
            ['name' => 'oudere erelid 2025', 'age_discount_id' => '6', 'membership_id' => '3', 'book_year_id' => '2', 'total_contribution_fee' => 45],

            ['name' => 'jeugd standaard 2026', 'age_discount_id' => '2', 'membership_id' => '2', 'book_year_id' => '3', 'total_contribution_fee' => 50],
            ['name' => 'jeugd erelid 2026', 'age_discount_id' => '2', 'membership_id' => '3', 'book_year_id' => '3', 'total_contribution_fee' => 40],
            ['name' => 'aspirant standaard 2026', 'age_discount_id' => '3', 'membership_id' => '2', 'book_year_id' => '3', 'total_contribution_fee' => 60],
            ['name' => 'aspirant erelid 2026', 'age_discount_id' => '3', 'membership_id' => '3', 'book_year_id' => '3', 'total_contribution_fee' => 50],
            ['name' => 'junior standaard 2026', 'age_discount_id' => '4', 'membership_id' => '2', 'book_year_id' => '3', 'total_contribution_fee' => 75],
            ['name' => 'junior erelid 2026', 'age_discount_id' => '4', 'membership_id' => '3', 'book_year_id' => '3', 'total_contribution_fee' => 65],
            ['name' => 'junior student 2026', 'age_discount_id' => '4', 'membership_id' => '4', 'book_year_id' => '3', 'total_contribution_fee' => 55],
            ['name' => 'senior standaard 2026', 'age_discount_id' => '5', 'membership_id' => '2', 'book_year_id' => '3', 'total_contribution_fee' => 100],
            ['name' => 'senior erelid 2026', 'age_discount_id' => '5', 'membership_id' => '3', 'book_year_id' => '3', 'total_contribution_fee' => 90],
            ['name' => 'senior student 2026', 'age_discount_id' => '5', 'membership_id' => '4', 'book_year_id' => '3', 'total_contribution_fee' => 80],
            ['name' => 'oudere standaard 2026', 'age_discount_id' => '6', 'membership_id' => '2', 'book_year_id' => '3', 'total_contribution_fee' => 55],
            ['name' => 'oudere student 2026', 'age_discount_id' => '6', 'membership_id' => '4', 'book_year_id' => '3', 'total_contribution_fee' => 35],
            ['name' => 'oudere erelid 2026', 'age_discount_id' => '6', 'membership_id' => '3', 'book_year_id' => '3', 'total_contribution_fee' => 45],
        ];

        foreach ($contributions as $contribution) {
            Contribution::create($contribution);
        }
    }
}
