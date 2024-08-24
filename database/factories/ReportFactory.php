<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'report_title' => $this->faker->sentence(),  // Generate a random report title
            'report_content' => $this->faker->paragraphs(3, true),  // Generate random report content
            'created_at' => now(),  // Set the current timestamp for creation
            'updated_at' => now(),  // Set the current timestamp for the last update
        ];
    }
}
