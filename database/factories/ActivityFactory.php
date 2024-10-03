<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
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

        $activityTypes = [
            'Call' => 'Phone call to discuss the next steps in the project.',
            'Meeting' => 'Meeting to finalize project requirements.',
            'Email' => 'Follow-up email outlining the next steps and timelines.',
            'Presentation' => 'Presentation of new product features to the client team.',
        ];

        $randomVerbs = ['discussed', 'talked about', 'mentioned', 'clarified', 'confirmed', 'asked about'];
        $randomTopics = ['budget', 'timeline', 'project expansion', 'integration', 'support options', 'contract'];

        $activityType = $this->faker->randomElement(array_keys($activityTypes));
        $activityDescription = $activityTypes[$activityType] . ' Topics included '
            . $this->faker->randomElement($randomVerbs)
            . ' regarding ' . $this->faker->randomElement($randomTopics) . '.';

        $outcomes = [
            'Call' => 'Client showed interest in extending the contract. Further details requested.',
            'Meeting' => 'Client is ready to sign. Next step is sending the contract draft.',
            'Email' => 'Client responded positively. Additional pricing information was sent.',
            'Presentation' => 'The presentation was successful. A demo is scheduled for next week.',
        ];

        $nextStepsOptions = [
            'Send a follow-up email with the required documents.',
            'Prepare a detailed project proposal and send it to the client.',
            'Schedule a follow-up meeting for further discussion.',
            'Provide a revised pricing structure based on the client’s feedback.',
            'Coordinate with the technical team to prepare a demo for the client.',
            'Confirm the contract draft and send it for approval.',
            'Gather more information from the client before proceeding with the next phase.',
            'Set up a call to clarify the next steps and assign responsibilities.',
            'Send an updated timeline based on the new requirements.',
            'Share a detailed report outlining the progress so far.'
        ];

        $notes = [
            'Call' => 'Client expressed interest in additional services.',
            'Meeting' => 'Concerns about delivery time were raised. Further negotiations planned.',
            'Email' => 'Quote details were sent to the client. Awaiting response.',
            'Presentation' => 'The client team was very engaged and asked many questions about integration.',
        ];

        return [
            'user_id' => $user->id,
            'deal_id' => $deal->id,
            'customer_id' => $deal->customer_id,
            'activity_type' => $activityType,
            'activity_description' => $activityDescription,
            'date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'status' => $this->faker->randomElement(['completed', 'pending', 'scheduled']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'location' => $this->faker->city(),
            'outcome' => $outcomes[$activityType],
            'notes' => $notes[$activityType] . ' Next steps: ' . $this->faker->randomElement($nextStepsOptions),
            'reminder' => $this->faker->dateTimeBetween('now', '+3 months'),
            'created_at' => $createdAt,
            'updated_at' => $this->faker->dateTimeBetween($createdAt, 'now'),
        ];
    }
}
