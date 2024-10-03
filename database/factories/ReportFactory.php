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
        $user = User::inRandomOrder()->first() ?? User::factory()->create();
        $userCreatedAt = $user->created_at;
        $createdAt = $this->faker->dateTimeBetween($userCreatedAt, 'now');

        $statusOptions = ['Draft', 'Published', 'Archived'];
        $status = $this->faker->randomElement($statusOptions);
        $durationInSeconds = $this->faker->numberBetween(3600, 172800);
        
        return [
            'user_id' => $user->id,
            'report_title' => $this->generateRealisticReportTitle(),
            'report_content' => $this->generateRealisticReportContent(),
            'status' => $status,
            'duration' => $durationInSeconds,
            'created_at' => $createdAt,
            'updated_at' => $this->faker->dateTimeBetween($createdAt, 'now'),
        ];
    }

    /**
     * Generate a realistic report title.
     *
     * @return string
     */
    protected function generateRealisticReportTitle(): string
    {
        $titles = [
            "Sales Performance Report",
            "Monthly Financial Summary",
            "Customer Feedback Analysis",
            "Project Progress Overview",
            "Annual Revenue Growth Report",
            "Market Trends and Insights",
            "Operational Efficiency Assessment",
            "Client Engagement Metrics"
        ];

        return $this->faker->randomElement($titles);
    }

    /**
     * Generate realistic report content.
     *
     * @return string
     */
    protected function generateRealisticReportContent(): string
    {
        $content = [
            "This report analyzes the sales performance over the last quarter and identifies key areas for improvement.",
            "The financial summary provides a comprehensive overview of the monthly expenditures and revenues.",
            "Customer feedback indicates a high level of satisfaction with our services, but we must address some common concerns.",
            "This project overview details the milestones achieved and outlines the next steps for completion.",
            "Revenue growth has shown promising trends, with several new clients contributing significantly to our profits.",
            "Market trends suggest an increasing demand for our products, necessitating a strategic response.",
            "Our operational efficiency has improved, with reduced costs and faster delivery times reported.",
            "Client engagement metrics highlight the effectiveness of our marketing strategies and customer outreach."
        ];

        return $this->faker->randomElement($content);
    }
}
