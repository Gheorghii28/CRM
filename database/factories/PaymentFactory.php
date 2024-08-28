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
        return [
            'customer_id' => Customer::inRandomOrder()->first()->id,
            'invoice_id' => Invoice::factory(),  
            'amount' => $this->faker->randomFloat(2, 1000, 100000),  
            'payment_date' => $this->faker->dateTimeBetween('-1 year', 'now'),  
            'payment_method' => $this->faker->randomElement(['Credit Card', 'Bank Transfer', 'PayPal']),  
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),  
        ];
    }
}
