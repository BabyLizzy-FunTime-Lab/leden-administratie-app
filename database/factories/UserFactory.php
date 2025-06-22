<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // A few conditions have been added to make the dummy data a bit more realistic.
            'name' => fake()->name(),
            'date_of_birth' => fake()->date(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'family_id' => fake()->numberBetween(2, 20),
            'family_role_id' => function (array $attributes) {
                $dateOfBirth = $attributes['date_of_birth'];
                $age = Carbon::parse($dateOfBirth)->age;
                // Only family members older than 51 can be grandparents.
                // Family members younger than 18 are sons or daughters.
                if($age >= 18 && $age <= 50 ) {
                    return fake()->numberBetween(2, 7);
                } elseif ($age >= 51) {
                    return fake()->numberBetween(4, 9);
                } elseif ($age < 18) {
                    return fake()->numberBetween(2, 3);
                }
            },
            'membership_id' => function (array $attributes) {
                $dateOfBirth = $attributes['date_of_birth'];
                $age = Carbon::parse($dateOfBirth)->age;
                // Only family members older than 17 can be student members.
                if($age < 17 ) {
                    return fake()->numberBetween(2, 3);
                } else {
                    return fake()->numberBetween(2, 4);
                }
            },
            'access_level_id' => 2,
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'contribution_id' => function(array $attributes) {
                // The attributes array contains the values that were auto generated
                $dateOfBirth = $attributes['date_of_birth'];
                $age = Carbon::parse($dateOfBirth)->age;
                $membership = $attributes['membership_id'];

                // Contribution depends on age and membership.
                switch (true) {
                    case $age < 8:
                        return ($membership == 2) ? 2 : 3;
                        break;
                    case $age >= 8 && $age <= 12:
                        return ($membership == 2) ? 4 : 5;
                        break;
                    case $age >= 13 && $age <= 17:
                        return match ($membership) {
                            2 => 6,
                            3 => 7,
                            default => 8,
                        };
                        break;
                    case $age >= 18 && $age <= 50:
                        return match ($membership) {
                            2 => 9,
                            3 => 10,
                            default => 11,
                        };
                        break;
                    case $age > 50:
                        return match ($membership) {
                            2 => 12,
                            3 => 14,
                            default => 13,
                        };
                        break;
                    default:
                        return 9;
                        break;
                }
            }
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
