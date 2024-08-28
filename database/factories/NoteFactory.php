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
        $createdAt = $this->faker->dateTimeBetween('-30 days', 'now');

        return [
            'user_id' => User::inRandomOrder()->first()->id,  
            'customer_id' => Customer::inRandomOrder()->first()->id,  
            'deal_id' => Deal::factory(), 
            'note_content' => $this->faker->paragraph(),  
            'created_at' => $createdAt,  
            'updated_at' => $createdAt,  
        ];
    }
}
