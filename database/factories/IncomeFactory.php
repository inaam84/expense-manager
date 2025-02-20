<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class IncomeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'vehicle_id' => $this->faker->randomElement(Vehicle::pluck('id')->toArray()),
            'amount' => $this->faker->numberBetween(100, 150),
            'income_date' => $this->faker->dateTimeBetween('-6 months', '+1 months'),
            'details' => $this->faker->paragraph(),
        ];
    }
}
