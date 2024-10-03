<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(20)->create();
        \App\Models\Customer::factory(100)->create();
        \App\Models\Contact::factory(10)->create();
        \App\Models\Deal::factory(100)->create();
        \App\Models\Activity::factory(100)->create();
        \App\Models\Note::factory(100)->create();
        \App\Models\Report::factory(100)->create();
        \App\Models\Invoice::factory(100)->create();
        \App\Models\Payment::factory(100)->create();
        \App\Models\Transaction::factory(100)->create();
        \App\Models\Task::factory(10)->create();
    }
}
