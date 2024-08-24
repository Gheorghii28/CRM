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
        return [
            'customer_id' => Customer::inRandomOrder()->first()->id,  // Erzeugt einen zufälligen Kunden
            'transaction_type' => $this->faker->randomElement(['payment', 'refund', 'chargeback']),  // Zufälliger Transaktionstyp
            'transaction_date' => $this->faker->dateTimeBetween('-1 year', 'now'),  // Zufälliges Datum in der Vergangenheit
            'amount' => $this->faker->randomFloat(2, 1000, 100000),  
            'description' => $this->faker->sentence(),  // Zufällige Beschreibung
        ];
    }
}
