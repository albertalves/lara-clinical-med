<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'specialty' => $this->faker->randomElement(['Cardiologia', 'Neurologia', 'Oncologia', 'Pediatria', 'Psiquiatria']),
            'city_id' => City::all()->random()->id,
        ];
    }
}
