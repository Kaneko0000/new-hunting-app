<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hunter>
 */
class HunterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('090########'),
            'region' => '熊本県',
            'password' => Hash::make('password'), // テスト用
            'status' => 'approved',
            'role' => 'hunter',
            'license_expiry' => now()->addYear(),
            'terms_accepted' => 1,
            'privacy_accepted' => 1,
        ];
    }
}
