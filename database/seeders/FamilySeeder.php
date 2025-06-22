<?php

namespace Database\Seeders;

use App\Models\Family;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // All families except for the "personeel" family are randomly populated
        // with fake users.

        // Only admins are part of the "personeel" family.
        Family::factory()->create([
            'name' => 'Personeel',
            'address' => 'Bedrijfskantoor 1',
        ]);

        // This creates a test family.
        Family::factory()->create([
            'name' => 'Test Family',
            'address' => 'Test Street #1',
        ]);

        // Now we create a few families with random data.
        Family::factory(20)->create();
    }
}
