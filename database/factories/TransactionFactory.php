<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
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
        $transactionDate = $this->faker->dateTimeBetween($createdAt, 'now');

        return [
            'customer_id' => $customer->id,
            'transaction_type' => $this->faker->randomElement(['payment', 'refund', 'chargeback']),
            'transaction_date' => $transactionDate,
            'amount' => $this->faker->randomFloat(2, 1000, 100000),  
            'description' => $this->generateRealisticDescription(),
            'created_at' => $createdAt,
            'updated_at' => $this->faker->dateTimeBetween($createdAt, 'now'),
        ];
    }
        
    /**
     * Generate a realistic transaction description.
     *
     * @return string
     */
    protected function generateRealisticDescription(): string
    {
        $descriptions = [
            "Payment received for invoice #12345.",
            "Refund processed for order #98765.",
            "Chargeback initiated due to unauthorized transaction.",
            "Payment for monthly subscription fee.",
            "Refund issued for returned merchandise.",
            "Chargeback due to fraud investigation.",
            "Payment received for consulting services.",
            "Refund for service cancellation."
        ];

        return $this->faker->randomElement($descriptions);
    }
}
