<?php

namespace Database\Factories;

use App\Models\UserResoum;
use Illuminate\Database\Eloquent\Factories\Factory;
use function App\Helpers\arr2str;
/**
 * @extends Factory<UserResoum>
 */
class UserResoumFactory extends Factory{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array{



        $JobClassification = config('constants.job_classification');
        $selected_Expertise_category = (fake()->randomElements($JobClassification,2));
        $selected_JobStatus = fake()->randomElement(config('constants.job_status'));
        return [
            'likes' => [],
            'public'=>(boolean)rand(0,1),
            'job_title'=>fake()->jobTitle,
            'job_status'=>$selected_JobStatus,
            'expertise_category'=>$selected_Expertise_category,
            'skills'=> ['react native','java script','html','css'],
            'years_of_birthday'=>rand(1350,1402),
            'languages'=>$create_languages,
            'about'=>fake()->text()
        ];
    }

    public function cteateLanguages() : array{
        $create_languages = [];
        $languages = config('constants.languages');
        $LangMasteryLevel = config('constants.lang_mastery_level');
        $language_count = count($languages);
        $know_language_count = rand(1,$language_count);
        for ($i=0;$i<$know_language_count;$i++){
            $selected_LangMasteryLevel = fake()->randomElement($LangMasteryLevel);
            $selected_languagecode = fake()->randomElement($languages);
            $create_languages[] = ['mastery_level'=>$selected_LangMasteryLevel,'language-code'=>$selected_languagecode];
        }
        return $create_languages;
    }
}
