<?php

namespace App\Providers;

use App\Club;
use App\ContactInformation;
use App\Feedback;
use App\ImgurImage;
use App\Observers\ActivityObserver;
use App\Observers\ClubObserver;
use App\Observers\ContactInformationObserver;
use App\Observers\FeedbackObserver;
use App\Observers\ImgurImageObserver;
use App\Observers\QrcodeObserver;
use App\Observers\RecordObserver;
use App\Observers\StudentObserver;
use App\Observers\StudentSurveyObserver;
use App\Observers\TeaPartyObserver;
use App\Observers\UserObserver;
use App\Qrcode;
use App\Record;
use App\Student;
use App\StudentSurvey;
use App\TeaParty;
use App\User;
use Carbon\Carbon;
use Horizon;
use Illuminate\Support\ServiceProvider;
use Purifier;
use Schema;
use Spatie\Activitylog\Models\Activity;
use Validator;

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
        Carbon::setLocale(config('app.locale'));

        //偵測 X-Requested-With
        $xRequestedWithMessage = $this->detectXRequestedWith();
        view()->share('xRequestedWithMessage', $xRequestedWithMessage);

        //Observers
        Activity::observe(ActivityObserver::class);
        User::observe(UserObserver::class);
        Student::observe(StudentObserver::class);
        Qrcode::observe(QrcodeObserver::class);
        Record::observe(RecordObserver::class);
        ImgurImage::observe(ImgurImageObserver::class);
        Club::observe(ClubObserver::class);
        StudentSurvey::observe(StudentSurveyObserver::class);
        Feedback::observe(FeedbackObserver::class);
        ContactInformation::observe(ContactInformationObserver::class);
        TeaParty::observe(TeaPartyObserver::class);

        Horizon::auth(function ($request) {
            return \Laratrust::can('horizon.manage');
        });

        //Validation rules
        Validator::extend('strip_max', function ($attribute, $value, $parameters, $validator) {
            /** @var Validator $validator */
            $validator->addReplacer('strip_max', function ($message, $attribute, $rule, $parameters) {
                return str_replace([':max'], $parameters, $message);
            });
            //確保字數計算結果與前端 TinyMCE 相同
            $cleanedText = str_replace("\n", '', strip_tags(Purifier::clean($value)));

            return mb_strlen($cleanedText) <= $parameters[0];
        });
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

    /**
     * 偵測 X-Requested-With，若非瀏覽器，回傳提示訊息
     *
     * @return null|string
     */
    private function detectXRequestedWith()
    {
        $xRequestedWith = request()->header('X-Requested-With');

        if (!$xRequestedWith) {
            return null;
        }
        $appName = null;
        if ($xRequestedWith == 'com.facebook.orca') {
            $appName = 'Messenger';
        }
        if ($xRequestedWith == 'com.facebook.katana') {
            $appName = 'Facebook';
        }

        if ($appName) {
            return "您似乎正在使用 {$appName} 瀏覽此網站";
        }

        if (starts_with($xRequestedWith, 'com.appspotr')) {
            return '您似乎不是使用瀏覽器瀏覽此網站';
        }

        return null;
    }
}
