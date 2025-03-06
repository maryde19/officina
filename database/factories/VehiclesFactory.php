<?php

namespace Database\Factories;

use App\Models\Clients;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicles>
 */
class VehiclesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Clients::inRandomOrder()->first()->id, // Associa un cliente esistente o crea uno nuovo
            'brand' => $this->faker->company,
            'model' => $this->faker->word,
            'year' => $this->faker->year,
            'license_plate' => strtoupper($this->faker->unique()->bothify('??###??')), // Es: AB123CD
        ];
    }
}
