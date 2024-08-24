<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deal>
 */
class DealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $createdAt = $this->faker->dateTimeBetween('-30 days', 'now');

        return [
            'customer_id' => Customer::inRandomOrder()->first()->id,
            'deal_name' => $this->faker->words(3, true),  // Generates a random deal name
            'deal_value' => $this->faker->randomFloat(2, 1000, 100000),  // Generates a random deal value between 1,000 and 100,000
            'stage' => $this->faker->randomElement(['prospecting', 'proposal', 'negotiation', 'won', 'lost']),  // Random stage
            'close_date' => $this->faker->dateTimeBetween($createdAt, '+1 year'),  // Generates a random close date
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }
}
