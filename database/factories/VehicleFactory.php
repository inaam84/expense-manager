<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'user_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
            'registration_number' => strtoupper($this->faker->unique()->bothify('??## ???')),
            'make' => $this->faker->randomElement(json_decode(file_get_contents(storage_path('app/data/vehicle_makes.json')), true)),
            'model' => $this->faker->word,
            'year' => $this->faker->year,
            'color' => $this->faker->safeColorName,
            'engine_size' => $this->faker->randomFloat(1, 1.0, 5.0).'L',
            'fuel_type' => $this->faker->randomElement(['Petrol', 'Diesel', 'Electric', 'Hybrid']),
            'mot_due_date' => $this->faker->dateTimeBetween('+1 months', '+8 months'),
            'tax_due_date' => $this->faker->dateTimeBetween('+1 months', '+8 months'),
            'insurance_due_date' => $this->faker->dateTimeBetween('+1 months', '+8 months'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
