<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use function App\Helpers\arr2str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array{
        $type = config('constants.post_type');
        $selected_type = $type[array_rand($type)];


        $JobClassification = config('constants.job_classification');
        $selected_JobClassification = fake()->randomElements($JobClassification, rand(0,3));

        $types_of_acceptable_contracts = config('constants.types_of_acceptable_contracts');
        $Type_of_cooperation = fake()->randomElements($types_of_acceptable_contracts,rand(1,count($types_of_acceptable_contracts)));

        $states = config('constants.states');
        $selected_states = fake()->randomElements($states, rand(0,3));

        $return = [
            'status'=> (fake()->randomElement(config('constants.post_status'))),
            'title'=>fake()->jobTitle,
            'type'=>$selected_type,
            'job_classification' => $selected_JobClassification,
            'description'=>fake()->realText,
            //optional
            'type_of_cooperation'=>$Type_of_cooperation,
            'benefit'=>(string)rand(10000,100000),
            'states'=>$selected_states,
        ];
        if ($selected_type === $type[0]){
            $return += [
                'work_experience'=>null,
                'job_position'=>null,
                'required_gender'=>null,
                'acceptable_military_service_status'=>null,
                'minimum_education_degree'=>null
            ];
        }else{//$selected_type === 'entrepreneur' === $type[1]
            $gender = config('constants.gender');
            $selected_gender = $gender[array_rand($gender)];
            $military_service_status = config('constants.military_service_status');
            $acceptable_military_service_status = ($selected_gender === 'male' ? fake()->randomElements($military_service_status,rand(1,count($military_service_status))) : null);
            $return += [
                'work_experience'=>rand(1,5)."<Y",
                'job_position'=>fake()->text,
                'required_gender'=>$selected_gender,
                'acceptable_military_service_status'=>$acceptable_military_service_status,
                'minimum_education_degree'=>fake()->randomElement(config('constants.grades'))
            ];
        }
        return $return;
    }
}
