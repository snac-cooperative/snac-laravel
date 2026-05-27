<?php

namespace Database\Factories;

use App\Models\Concept;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Term>
 */
class ConceptSourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'citation' => $this->faker->sentence(),
            'concept_id' => Concept::factory(),
            'found_data' => $this->faker->sentence(),
            'note' => $this->faker->paragraph(),
            'url' => $this->faker->url(),
        ];
    }
}
