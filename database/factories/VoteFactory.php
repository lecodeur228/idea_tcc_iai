<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Idea;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vote>
 */
class VoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $factory->define(Vote::class, function () {
            return [
                'id_address' => fake()->ipv4,
                'idea_id' => Idea::inRandomOrder()->first()?->id ?? 1,
            ];
        // });
    }
}
