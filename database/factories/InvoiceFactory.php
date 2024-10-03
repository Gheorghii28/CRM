<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customer = Customer::factory()->create() ?? Customer::factory()->create();
        $customerCreatedAt = $customer->created_at;
        $createdAt = $this->faker->dateTimeBetween($customerCreatedAt, 'now');

        return [
            'customer_id' => $customer->id, 
            'invoice_number' => 'INV-' . $this->faker->unique()->numerify('###-###-###'),
            'total_amount' => $this->faker->randomFloat(2, 1000, 100000), 
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'), 
            'status' => $this->faker->randomElement(['unpaid', 'paid', 'overdue']),
            'created_at' => $createdAt,
            'updated_at' => $this->faker->dateTimeBetween($createdAt, 'now'),
        ];
    }
}
