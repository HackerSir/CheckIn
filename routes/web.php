<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//首頁
Route::get('/', 'HomeController@index')->name('index');

//OAuth
Route::group(['prefix' => 'oauth', 'namespace' => 'Auth'], function () {
    Route::get('/', 'OAuthController@index')->name('oauth.index');
    Route::any('login', 'OAuthController@login')->name('oauth.login');
});

//服務條款(含隱私權跟免責)
Route::get('terms', function () {
    return view('misc.terms');
})->name('terms');

//服務條款(含隱私權跟免責)
Route::get('faq', function () {
    return view('misc.faq');
})->name('faq');

//會員（須完成信箱驗證）
Route::group(['middleware' => ['auth', 'email']], function () {
    //會員管理
    //權限：user.manage、user.view
    Route::resource('user', 'UserController', [
        'except' => [
            'create',
            'store',
        ],
    ]);
    //角色管理
    //權限：role.manage
    Route::group(['middleware' => 'permission:role.manage'], function () {
        Route::resource('role', 'RoleController', [
            'except' => [
                'show',
            ],
        ]);
    });
    //學生管理
    //權限：student.manage
    Route::group(['middleware' => 'permission:student.manage'], function () {
        Route::resource('student', 'StudentController', [
            'only' => [
                'index',
                'create',
                'store',
                'update',
            ],
        ]);
    });
    //QR Code管理
    //權限：qrcode.manage
    Route::group(['middleware' => 'permission:qrcode.manage'], function () {
        //綁定
        Route::get('qrcode/bind', 'QrcodeController@bindForm')->name('qrcode.bind');
        Route::post('qrcode/bind', 'QrcodeController@bind')->name('qrcode.bind');

        Route::resource('qrcode', 'QrcodeController', [
            'only' => [
                'index',
                'show',
            ],
        ]);

        //下載
        Route::post('qrcode-set/{qrcode_set}/download', 'QrcodeSetController@download')->name('qrcode-set.download');

        Route::resource('qrcode-set', 'QrcodeSetController', [
            'only' => [
                'index',
                'create',
                'store',
                'show',
            ],
        ]);
    });
    //攤位管理
    //權限：booth.manage
    Route::group(['middleware' => 'permission:booth.manage'], function () {
        Route::resource('booth', 'BoothController');
    });
    //社團類型管理
    //權限：club-type.manage
    Route::group(['middleware' => 'permission:club-type.manage'], function () {
        Route::resource('club-type', 'ClubTypeController', [
            'except' => [
                'show',
            ],
        ]);
    });
    //社團管理
    //權限：club.manage
    Route::group(['middleware' => 'permission:club.manage'], function () {
        Route::resource('club', 'ClubController');
    });
    //網站設定
    //權限：setting.manage
    Route::group(['middleware' => 'permission:setting.manage', 'prefix' => 'setting'], function () {
        Route::get('/', 'SettingController@edit')->name('setting.edit');
        Route::post('update', 'SettingController@update')->name('setting.update');
    });
    //ApiKey管理
    //權限：api-key.manage
    Route::group(['middleware' => 'permission:api-key.manage'], function () {
        Route::resource('api-key', 'ApiKeyController', [
            'except' => [
                'show',
                'edit',
                'update',
            ],
        ]);
    });
    //打卡紀錄管理
    //權限：record.manage
    Route::group(['middleware' => 'permission:record.manage'], function () {
        Route::resource('record', 'RecordController', [
            'only' => [
                'index',
            ],
        ]);
    });

    //抽獎編號管理
    //權限：ticket.manage
    Route::group(['middleware' => 'permission:ticket.manage'], function () {
        Route::resource('ticket', 'TicketController', [
            'only' => [
                'index',
            ],
        ]);
    });

    //QR Code 掃描
    Route::get('qr/{code}', 'QrcodeScanController@scan')->name('qrcode.scan');
    //條碼圖
    Route::group(['prefix' => 'code'], function () {
        Route::get('qrcode/{code}', 'CodePictureController@qrcode')->name('code-picture.qrcode');
        Route::get('barcode/{code}', 'CodePictureController@barcode')->name('code-picture.barcode');
    });

    //內部API
    Route::group(['prefix' => 'api'], function () {
        Route::post('/user-list', 'ApiController@userList')->name('api.user-list');
    });

    //會員資料
    Route::group(['prefix' => 'profile'], function () {
        //查看會員資料
        Route::get('/', 'ProfileController@getProfile')->name('profile');
        Route::group(['middleware' => 'local_account'], function () {
            //編輯會員資料
            Route::get('edit', 'ProfileController@getEditProfile')->name('profile.edit');
            Route::put('update', 'ProfileController@updateProfile')->name('profile.update');
            //兩步驟驗證
            Route::group(['prefix' => '2fa'], function () {
                Route::get('/', 'Google2FAController@index')->name('profile.2fa.index');
                Route::post('toggle', 'Google2FAController@toggle')->name('profile.2fa.toggle');
            });
        });
    });
});

//會員系統
//將 Auth::routes() 複製出來自己命名
Route::group(['namespace' => 'Auth'], function () {
    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login')->name('login');
    // Google 2FA
    Route::get('login/2fa', 'LoginController@login2FAForm')->name('login.2fa');
    Route::post('login/2fa', 'LoginController@login2FA')->name('login.2fa');

    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::post('logout', 'LoginController@logout')->name('logout');
    // Registration Routes...
    Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'RegisterController@register')->name('register');
    // Password Reset Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');
    Route::group(['middleware' => 'local_account'], function () {
        //修改密碼
        Route::get('password/change', 'PasswordController@getChangePassword')->name('password.change');
        Route::put('password/change', 'PasswordController@putChangePassword')->name('password.change');
    });
    //驗證信箱
    Route::get('resend', 'RegisterController@resendConfirmMailPage')->name('confirm-mail.resend');
    Route::post('resend', 'RegisterController@resendConfirmMail')->name('confirm-mail.resend');
    Route::get('confirm/{confirmCode}', 'RegisterController@emailConfirm')->name('confirm');
});
