<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ExampleJob;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ExampleJob::dispatch();
        $this->info('Test command executed successfully.');
    }
}
