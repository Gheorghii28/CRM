<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
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

        $jobTitles = [
            'Sales Manager', 'Marketing Director', 'Customer Support Lead', 
            'Business Development Manager', 'IT Consultant', 'Operations Director'
        ];

        $companies = [
            'Acme Corp', 'GlobalTech Solutions', 'InnovateX', 'Skyline Enterprises', 'BlueWave Consulting'
        ];

        return [
            'customer_id' => $customer->id,
            'contact_name' => $this->faker->name,
            'contact_email' => $this->faker->unique()->safeEmail,
            'contact_phone' => $this->faker->phoneNumber,
            'job_title' => $this->faker->randomElement($jobTitles),
            'company' => $this->faker->randomElement($companies),
            'created_at' => $createdAt,
            'updated_at' => $this->faker->dateTimeBetween($createdAt, 'now'),
        ];
    }
}
