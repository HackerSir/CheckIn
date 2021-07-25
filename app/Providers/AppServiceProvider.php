<?php

namespace App\Providers;

use App\Models\Club;
use App\Models\ContactInformation;
use App\Models\DataUpdateRequest;
use App\Models\Feedback;
use App\Models\ImgurImage;
use App\Models\Qrcode;
use App\Models\Record;
use App\Models\Student;
use App\Models\StudentSurvey;
use App\Models\TeaParty;
use App\Models\User;
use App\Observers\ActivityObserver;
use App\Observers\ClubObserver;
use App\Observers\ContactInformationObserver;
use App\Observers\DataUpdateRequestObserver;
use App\Observers\FeedbackObserver;
use App\Observers\ImgurImageObserver;
use App\Observers\QrcodeObserver;
use App\Observers\RecordObserver;
use App\Observers\StudentObserver;
use App\Observers\StudentSurveyObserver;
use App\Observers\TeaPartyObserver;
use App\Observers\UserObserver;
use Carbon\Carbon;
use Horizon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Laratrust;
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
        DataUpdateRequest::observe(DataUpdateRequestObserver::class);

        Horizon::auth(function ($request) {
            return Laratrust::isAbleTo('horizon.manage');
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

        // Use Bootstrap's Paginator
        Paginator::useBootstrap();
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
