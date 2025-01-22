<?php

namespace Database\Factories;

use App\Models\Vocabulary;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vocabulary>
 */
class VocabularyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Vocabulary::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Vocabulary::max('id') + 1,
            'type' => '',
            'value' => $this->faker->word,
            // 'uri' => '',
            // 'description' => '',
            // 'entity_group' => '',
        ];

    }


    /**
     * Vocabulary language
     */
    public function language(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'language_code',
            ];
        });
    }


}
