<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactsInfo>
 */

class ContactsInfoFactory extends Factory{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array{
        $fake = fake();
        return [
            'phone'=>$fake->phoneNumber,
            'email'=>$fake->email,
            'telegram'=>$fake->userName,
            'instagram'=>$fake->userName,
            'web'=>$fake->url,
            'linkedin'=>$fake->userName,
            'location'=>$fake->userName
        ];
    }
}
