<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class BackupRun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run database backup';

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
        $filename = Carbon::now()->format('Ymd_His');
        $this->call('db:backup', [
            '--database'        => env('DB_CONNECTION'),
            '--destination'     => 'local',
            '--destinationPath' => $filename,
            '--compression'     => 'gzip',
        ]);
    }
}
