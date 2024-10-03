<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first() ?? User::factory()->create();
        $deal = Deal::inRandomOrder()->first() ?? Deal::factory()->create();
        $dealCreatedAt = $deal->created_at;
        $createdAt = $this->faker->dateTimeBetween($dealCreatedAt, 'now');

        return [
            'user_id' => $user->id,  
            'deal_id' => $deal->id, 
            'customer_id' => $deal->customer_id,  
            'note_content' => $this->generateRealisticNote(),  
            'created_at' => $createdAt,
            'updated_at' => $this->faker->dateTimeBetween($createdAt, 'now'),
        ];
    }

    /**
     * Generate a realistic note content.
     *
     * @return string
     */
    protected function generateRealisticNote(): string
    {
        $noteContents = [
            "Follow up with the client regarding the last proposal.",
            "Discuss the terms of the deal with the sales team.",
            "Client expressed concerns about the pricing.",
            "Schedule a meeting for next week to finalize the details.",
            "Review the contract terms before sending it to the client.",
            "Client is interested in additional services, need to prepare an offer.",
            "Prepare a presentation for the upcoming meeting with the client.",
            "Client's feedback was positive, proceed with the next steps."
        ];

        return $this->faker->randomElement($noteContents);
    }
}
