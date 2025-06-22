<?php

namespace Database\Seeders;

use App\Models\AgeDiscount;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            FamilySeeder::class,
            FamilyRoleSeeder::class,
            AccessLevelSeeder::class,
            BookYearSeeder::class,
            AgeDiscountSeeder::class,
            MembershipSeeder::class,
            ContributionSeeder::class,
        ]);

        // create the admin
        User::factory()->create([
            'name' => 'admin',
            'date_of_birth' => '1983-01-01',
            'email' => 'test@example.com',
            'family_id' => '1',
            'family_role_id' => '1',
            'membership_id' => '1',
            'access_level_id' => '1',
            'contribution_id' => '1',
        ]);

        // create the test user (family member)
        User::factory()->create([
            'name' => 'Mr. Test',
            'date_of_birth' => '1983-01-01',
            'email' => 'testbro@example.com',
            'family_id' => '2',
            'family_role_id' => '6',
            'membership_id' => '2',
            'access_level_id' => '2',
            'contribution_id' => '9',
        ]);

        // Then seed with random fake users.
        User::factory(45)->create();


    }
}
