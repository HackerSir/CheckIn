<?php

namespace App\Console\Commands;

use App\Http\Controllers\Auth\RegisterController;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use URL;

class UserCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user';

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
        $this->info('Creating new user...');
        $isFirstUser = User::count() == 0;
        if ($isFirstUser) {
            $this->warn('This is the first user, it will be an administrator automatically.');
        }
        //帳號
        do {
            $email = $this->ask('Please input the email');
            $isOk = true;
            if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
                $isOk = false;
                $this->error('Invalid email address, please retry...');
            } elseif (User::whereEmail($email)->count() > 0) {
                $isOk = false;
                $this->error("The email \"{$email}\" has been used, please try another one...");
            }
        } while (!$isOk);
        //密碼
        do {
            $password = $this->secret('Please input the password (Hidden input)');
            $confirmPassword = $this->secret('Please input the password again (Hidden input)');
            $isOk = true;
            if (mb_strlen($password) < 6) {
                $isOk = false;
                $this->error('Password too short, please retry...');
            } elseif ($password != $confirmPassword) {
                $isOk = false;
                $this->error('Password not match, please retry...');
            }
        } while (!$isOk);
        //建立使用者
        /** @var User $user */
        $user = User::create([
            'name'        => preg_split('/@/', $email)[0],
            'email'       => $email,
            'password'    => bcrypt($password),
            'register_at' => Carbon::now(),
            'register_ip' => request()->getClientIp(),
        ]);

        if ($isFirstUser) {
            $admin = Role::where('name', '=', 'Admin')->first();
            $user->attachRole($admin);
        }

        $this->info("User \"{$email}\" created successfully.");

        //驗證信件
        $this->info('Sending confirmation email...');
        //設定專案路徑
        URL::forceRootUrl(config('app.url'));
        //發送驗證信件
        app(RegisterController::class)->generateConfirmCodeAndSendConfirmMail($user);
        $this->info('Confirmation email sent successfully.');
    }
}
