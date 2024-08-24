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
        return [
            'customer_id' => Customer::factory(), // Verweis auf die Customer Factory
            'invoice_number' => 'INV-' . $this->faker->unique()->numerify('###-###-###'),
            'total_amount' => $this->faker->randomFloat(2, 1000, 100000), // Zufälliger Betrag zwischen 1000 und 100000
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'), // Zufälliges Fälligkeitsdatum in der Zukunft
            'status' => $this->faker->randomElement(['unpaid', 'paid', 'overdue']), // Zufälliger Status
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
