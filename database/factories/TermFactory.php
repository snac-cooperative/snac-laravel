<?php

namespace Database\Factories;

use App\Models\Concept;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Term>
 */
class TermFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => $this->faker->word,
            'preferred' => false,
            'concept_id' => Concept::factory(),
        ];
    }
}
