<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HunterLog>
 */
class HunterLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hunter_id' => \App\Models\Hunter::factory(),
            'animal_id' => rand(1, 5), // 事前に5種類ぐらい用意しておくといい
            'weather_id' => rand(1, 5),
            'latitude' => $this->faker->latitude(32.4, 32.6),
            'longitude' => $this->faker->longitude(130.0, 130.2),
            'capture_date' => $this->faker->date(),
            'comments' => $this->faker->sentence(),
        ];
    }
}
