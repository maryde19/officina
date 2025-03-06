<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clients>
 */
class ClientsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,         // Nome casuale
            'email' => $this->faker->unique()->safeEmail, // Email univoca
            'phone' => $this->faker->phoneNumber, // Numero di telefono casuale
            'address' => $this->faker->address,   // Indirizzo casuale
        ];
    }
}
