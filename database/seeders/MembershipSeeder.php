<?php

namespace Database\Seeders;

use App\Models\Membership;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $memberships = [
            ['name' => 'personeel', 'discount_percentage' => 100],
            ['name' => 'standaard', 'discount_percentage' => 0],
            ['name' => 'erelid',    'discount_percentage' => 10],
            ['name' => 'student',   'discount_percentage' => 20],
        ];
        foreach ($memberships as $membership) {
            Membership::create($membership);
        }
    }
}
