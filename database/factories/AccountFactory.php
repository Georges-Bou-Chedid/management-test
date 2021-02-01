<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sid' => $this->faker->randomDigit,
            'name' => $this->faker->name,
            'type' => $this->faker->sentence,
            'country' => 'LB',
            'workspace' => $this->faker->sentence,
            'transactional_email' => $this->faker->unique()->safeEmail,
            'transactional_phone' => $this->faker->phoneNumber,
            'timezone' => $this->faker->sentence,
            'created_at' => now(), 
            'updated_at' => now(), 
            
        ];
    }
}
