<?php

namespace App\Console\Commands;

use App\ApiKey;
use Illuminate\Console\Command;
use Log;

class ResetApiKeyCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api-key:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset count of all ApiKey';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ApiKey::query()->update(['count' => 0]);
        $this->info('Counts of all ApiKey have been reset.');

        Log::debug('Counts of all ApiKey have been reset.');
    }
}
