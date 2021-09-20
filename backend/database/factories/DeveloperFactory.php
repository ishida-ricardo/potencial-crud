<?php

namespace Database\Factories;

use App\Models\Developer;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeveloperFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Developer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'sex' => $this->faker->randomElement(['M', 'F']),
            'age' => $this->faker->numberBetween(18, 80),
            'hobby' => $this->faker->word(),
            'birth_date' =>  $this->faker->date(),
        ];
    }
}
