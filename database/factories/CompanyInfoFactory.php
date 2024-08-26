<?php

namespace Database\Factories;

use App\Models\CompanyInfo;
use Illuminate\Database\Eloquent\Factories\Factory;
use function App\Helpers\arr2str;

/**
 * @extends Factory<CompanyInfo>
 */
class CompanyInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array{
        $JobClassification = config('constants.job_classification');
        $selected_category = fake()->randomElements($JobClassification,3);

        return [
            'likes' => 0,
            'category'=>$selected_category,
            'number_of_ex'=>rand(0,300),
            'build_year'=>fake()->dateTime(),
            'description'=>fake()->text
        ];
    }
}
