<?php

namespace Database\Factories;

use App\Models\studyexp;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\studyexp>
 */
class StudyExpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'field_of_study'=>fake()->jobTitle,
            'university'=>fake()->name,
            'grade'=>fake()->randomElement(config('constants.grades')),
            'description'=>fake()->text
        ];
    }
}
