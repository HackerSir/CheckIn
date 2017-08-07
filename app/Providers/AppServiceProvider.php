<?php

namespace App\Providers;

use App\ImgurImage;
use App\Observers\ImgurImageObserver;
use App\Observers\QrcodeObserver;
use App\Observers\RecordObserver;
use App\Observers\StudentObserver;
use App\Qrcode;
use App\Record;
use App\Student;
use Carbon\Carbon;
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

        //Carbon語系
        Carbon::setLocale(env('APP_LOCALE', 'en'));

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

        //Observers
        Qrcode::observe(QrcodeObserver::class);
        Student::observe(StudentObserver::class);
        Record::observe(RecordObserver::class);
        ImgurImage::observe(ImgurImageObserver::class);
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
