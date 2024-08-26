<?php

namespace Database\Factories;

use App\Models\CareerPreference;
use Illuminate\Database\Eloquent\Factories\Factory;
use function App\Helpers\arr2str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CareerPreference>
 */
class CareerPreferenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array{

        $states = config('constants.states');
        $selected_states = fake()->randomElements($states, rand(0,3));

        $JobClassification = config('constants.job_classification');
        $selected_JobClassification = fake()->randomElements($JobClassification, rand(1,3));

        $level_of_activity = config('constants.level_of_activity');
        $selected_level_of_activity = fake()->randomElements($level_of_activity, rand(1,3));

        $Types_of_acceptable_contracts = config('constants.types_of_acceptable_contracts');
        $selected_Types_of_acceptable_contracts = fake()->randomElements($Types_of_acceptable_contracts, rand(1,3));

        $Desired_job_benefits = config('constants.desired_job_benefits');
        $selected_Desired_job_benefits = fake()->randomElements($Desired_job_benefits, rand(1,3));

        return [
            'states' =>$selected_states,
            'job_classification' => $selected_JobClassification,
            'level_of_activity' => $selected_level_of_activity,
            'types_of_acceptable_contracts' => $selected_Types_of_acceptable_contracts,
            'minimum_salary_requested' => (string)rand(1000, 99999),
            'desired_job_benefits' => $selected_Desired_job_benefits
        ];
    }
}
