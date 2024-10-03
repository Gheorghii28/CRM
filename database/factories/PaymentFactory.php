<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $invoice = Invoice::inRandomOrder()->first() ?? Invoice::factory()->create();
        $invoiceCreatedAt = $invoice->created_at;
        $createdAt = $this->faker->dateTimeBetween($invoiceCreatedAt, 'now');
        $paymentDate = $this->faker->dateTimeBetween($createdAt, 'now');

        return [
            'invoice_id' => $invoice->id,  
            'customer_id' => $invoice->customer_id,
            'amount' => $this->faker->randomFloat(2, 1000, 100000),  
            'payment_date' => $paymentDate,  
            'payment_method' => $this->faker->randomElement(['Credit Card', 'Bank Transfer', 'PayPal']),  
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),  
            'created_at' => $createdAt,
            'updated_at' => $this->faker->dateTimeBetween($createdAt, 'now'),
        ];
    }
}
