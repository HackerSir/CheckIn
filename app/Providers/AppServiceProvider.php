<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        //Slack通知
        $slackEnable = env('SLACK_ENABLE', false) === true;
        $slackToken = env('SLACK_TOKEN');
        $slackChannel = env('SLACK_CHANNEL');
        if ($slackEnable && $slackToken && $slackChannel) {
            $monolog = \Log::getMonolog();
            $slackHandler = new \Monolog\Handler\SlackHandler(
                $slackToken,
                $slackChannel,
                'Monolog',
                true,
                null,
                Logger::WARNING
            );
            $monolog->pushHandler($slackHandler);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
