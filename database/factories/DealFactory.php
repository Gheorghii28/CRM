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
        $customer = Customer::inRandomOrder()->first() ?? Customer::factory()->create();
        $customerCreatedAt = $customer->created_at;
        $createdAt = $this->faker->dateTimeBetween($customerCreatedAt, 'now');

        return [
            'customer_id' => $customer->id,
            'deal_name' => $this->faker->catchPhrase(), 
            'deal_value' => $this->faker->randomFloat(2, 1000, 100000),
            'stage' => $this->faker->randomElement(['prospecting', 'proposal', 'negotiation', 'won', 'lost']),
            'close_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'created_at' => $createdAt,
            'updated_at' => $this->faker->dateTimeBetween($createdAt, 'now'),
        ];
    }
}
