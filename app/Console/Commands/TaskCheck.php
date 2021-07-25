<?php

namespace App\Console\Commands;

use App\Models\Student;
use App\Services\TaskService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class TaskCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:check {nid?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check task progress of student(s)';

    /**
     * Create a new command instance.
     *
     * @return void
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
        $nid = Str::upper($this->argument('nid'));
        $studentQuery = Student::query();
        if ($nid) {
            $this->info('Query student with NID: ' . $nid);
            $studentQuery->where('nid', $nid);
        }
        $studentCount = $studentQuery->count();
        if ($studentCount == 0) {
            $this->error('No students found');

            return;
        }
        $taskService = app(TaskService::class);
        $this->info('Starting checking...');
        $bar = $this->output->createProgressBar($studentCount);
        $bar->setFormat('%current%/%max% [%bar%] %percent:3s%% %message%');
        $bar->start();

        $studentQuery->chunk(100, function ($students) use ($taskService, &$bar) {
            /** @var Student $student */
            foreach ($students as $student) {
                $bar->setMessage('Checking Student: ' . $student->display_name);
                $taskService->checkProgress($student);
                $bar->advance();
            }
        });
        $bar->setMessage('');
        $bar->finish();
        $this->info('');
        $this->info('Checking finished');
    }
}
