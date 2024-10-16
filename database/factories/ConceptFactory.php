<?php

namespace Database\Factories;

use App\Models\Concept;
use App\Models\Term;
use App\Models\Vocabulary;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Concept>
 */
class ConceptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'deprecated' => false,
        ];
    }

    /**
     * Indicate that the concept should have categories and terms.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function configure()
    {
        $categoryIds = Vocabulary::where('type', 'concept_category')->pluck('id')->toArray();

        return $this->afterCreating(function (Concept $concept) use ($categoryIds) {
            // Attach a random category
            $concept->conceptCategories()->attach(Arr::random($categoryIds));

            // Create terms
            Term::factory()->count(3)->create(['concept_id' => $concept->id]);
        });
    }
}
