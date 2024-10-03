<?php

namespace Database\Factories;

use App\Models\Deal;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
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
        $userCreatedAt = $user->created_at;
        $dealCreatedAt = $deal->created_at;
        $createdAt = $this->faker->dateTimeBetween(max($userCreatedAt, $dealCreatedAt), 'now');
        $statusOptions = ['to-do', 'in-progress', 'done'];
        $status = $this->faker->randomElement($statusOptions);
        $existingCount = Task::where('status', $status)->count();
        $order = $existingCount;

        return [
            'user_id' => $user->id,
            'deal_id' => $deal->id,
            'title' => $this->generateRealisticTaskTitle(),
            'task_description' => $this->generateRealisticTaskDescription(),
            'due_date' => $this->faker->dateTimeBetween('now', '+3 months'),
            'status' => $status,
            'order' => $order,
            'created_at' => $createdAt,
            'updated_at' => $this->faker->dateTimeBetween($createdAt, 'now'),
        ];
    }

    /**
     * Generate a realistic task title.
     *
     * @return string
     */
    protected function generateRealisticTaskTitle(): string
    {
        $titles = [
            "Follow up with client",
            "Prepare project proposal",
            "Schedule team meeting",
            "Complete the financial report",
            "Review the contract details",
            "Update the project timeline",
            "Conduct market research",
            "Draft the newsletter"
        ];

        return $this->faker->randomElement($titles);
    }

    /**
     * Generate a realistic task description.
     *
     * @return string
     */
    protected function generateRealisticTaskDescription(): string
    {
        $descriptions = [
            "Ensure to follow up with the client regarding their feedback on the last proposal.",
            "Prepare a detailed project proposal including timelines and deliverables.",
            "Schedule a team meeting to discuss the progress of ongoing projects.",
            "Complete the financial report by gathering data from the last quarter.",
            "Review the contract details and prepare a summary for the legal team.",
            "Update the project timeline based on the latest developments.",
            "Conduct market research to identify new opportunities and trends.",
            "Draft the newsletter for the upcoming month, including recent updates and news."
        ];

        return $this->faker->randomElement($descriptions);
    }
}
