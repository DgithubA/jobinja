<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkExp>
 */
class WorkExpFactory extends Factory{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'job_title'=>fake()->jobTitle,
            'company_name'=>fake()->company(),
            'description'=>fake()->text()
        ];
    }

}
