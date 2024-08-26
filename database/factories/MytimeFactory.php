<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MyTime>
 */
class MytimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $end = fake()->dateTime();
        $from = fake()->dateTime($end);
        $in_pregress = (boolean)rand(0,1);
        return [
            'from'=>$from,
            'in_progress'=> $in_pregress,
            'end'=> ($in_pregress ? null : $end)
        ];
    }
}
