<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Helpers\CountryHelper;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do {
            $createdAt = $this->faker->dateTimeBetween('-30 days', 'now');
            $firstname = $this->faker->firstName();
            $lastname = $this->faker->lastName();
            $email = $this->faker->unique()->safeEmail();
            $phone = $this->faker->e164PhoneNumber();
            $city = $this->faker->city();
            $stateprovince = $this->faker->state();
            $streetaddress = $this->faker->streetAddress();
            $zip = $this->faker->postcode();
            $country = $this->faker->country();
            $countries = CountryHelper::getCountries();
            $countryCode = $countries[$country] ?? '';
        } while (empty($countryCode));

        return [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'phone' => $phone,
            'city' => $city,
            'stateprovince' => $stateprovince,
            'streetaddress' => $streetaddress,
            'zip' => $zip,
            'country' => $countryCode,
            'created_at' => $createdAt,
            'updated_at' => $this->faker->dateTimeBetween($createdAt, 'now'),
        ];
    }
}
