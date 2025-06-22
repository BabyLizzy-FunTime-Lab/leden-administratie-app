<?php

namespace Database\Seeders;

use App\Models\FamilyRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FamilyRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['n.v.t.', 'Zoon', 'Dochter', 'Oom', 'Tante', 'Vader', 'Moeder',  'Opa', 'Oma'];

        foreach ($roles as $role) {
            FamilyRole::firstOrCreate(['name' => $role]);
        }
    }
}
