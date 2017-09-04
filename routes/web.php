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

Route::get('clubs', 'HomeController@clubs')->name('clubs.index');
Route::get('clubs/{club}', 'HomeController@clubsShow')->name('clubs.show');
Route::get('map', 'HomeController@clubsMap')->name('clubs.map');

//服務條款(含隱私權跟免責)
Route::get('terms', function () {
    return view('misc.terms');
})->name('terms');

//常見問題
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
                'show',
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
    });
    //QR Code集管理
    //權限：qrcode-set.manage
    Route::group(['middleware' => 'permission:qrcode-set.manage'], function () {
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
        Route::get('booth/import', 'BoothController@getImport')->name('booth.import');
        Route::post('booth/import', 'BoothController@postImport')->name('booth.import');
        Route::get('booth/download-import-sample', 'BoothController@downloadImportSample')
            ->name('booth.download-import-sample');
        Route::resource('booth', 'BoothController');
    });
    //社團類型管理
    //權限：club-type.manage
    Route::group(['middleware' => 'permission:club-type.manage'], function () {
        Route::post('club-type/store-default', 'ClubTypeController@storeDefault')->name('club-type.store-default');
        Route::resource('club-type', 'ClubTypeController', [
            'except' => [
                'show',
            ],
        ]);
    });
    //社團管理
    //權限：club.manage
    Route::group(['middleware' => 'permission:club.manage'], function () {
        Route::get('club/import', 'ClubController@getImport')->name('club.import');
        Route::post('club/import', 'ClubController@postImport')->name('club.import');
        Route::get('club/download-import-sample', 'ClubController@downloadImportSample')
            ->name('club.download-import-sample');
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
        Route::post('export/record', 'ExportController@record')->name('export.record');
        Route::resource('record', 'RecordController', [
            'only' => [
                'index',
            ],
        ]);
    });

    //抽獎編號管理
    //權限：ticket.manage
    Route::group(['middleware' => 'permission:ticket.manage'], function () {
        Route::get('ticket/ticket', 'TicketController@ticket')->name('ticket.ticket');
        Route::get('ticket/info', 'TicketController@ticketInfo')->name('ticket.info');
        Route::resource('ticket', 'TicketController', [
            'only' => [
                'index',
            ],
        ]);
    });
    //隊輔抽獎編號管理
    //權限：extra-ticket.manage
    Route::group(['middleware' => 'permission:extra-ticket.manage'], function () {
        Route::get('extra-ticket/ticket', 'ExtraTicketController@ticket')->name('extra-ticket.ticket');
        Route::get('extra-ticket/info', 'ExtraTicketController@ticketInfo')->name('extra-ticket.info');
        Route::get('extra-ticket/import', 'ExtraTicketController@getImport')->name('extra-ticket.import');
        Route::post('extra-ticket/import', 'ExtraTicketController@postImport')->name('extra-ticket.import');
        Route::get('extra-ticket/download-import-sample', 'ExtraTicketController@downloadImportSample')
            ->name('extra-ticket.download-import-sample');
        Route::delete('extra-ticket/destroy-all', 'ExtraTicketController@destroyAll')->name('extra-ticket.destroy-all');
        Route::resource('extra-ticket', 'ExtraTicketController', [
            'except' => [
                'show',
            ],
        ]);
    });

    //Feedback
    Route::get('feedback/create/{club}', 'FeedbackController@create')->name('feedback.create');
    Route::post('feedback/{club}', 'FeedbackController@store')->name('feedback.store');
    Route::post('export/feedback', 'ExportController@feedback')->name('export.feedback');
    Route::resource('feedback', 'FeedbackController', [
        'only' => [
            'index',
            'show',
        ],
    ]);

    //自己的社團
    Route::group(['prefix' => 'own-club'], function () {
        Route::get('/', 'OwnClubController@show')->name('own-club.show');
        Route::get('edit', 'OwnClubController@edit')->name('own-club.edit');
        Route::patch('update', 'OwnClubController@update')->name('own-club.update');
    });

    //QR Code 掃描
    Route::get('qr/{code}', 'QrcodeScanController@scan')->name('qrcode.scan');
    //條碼圖
    Route::group(['prefix' => 'code'], function () {
        Route::get('qrcode/{code}', 'CodePictureController@qrcode')->name('code-picture.qrcode');
        Route::get('barcode/{code}', 'CodePictureController@barcode')->name('code-picture.barcode');
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

//內部API
Route::group(['prefix' => 'api'], function () {
    Route::post('/user-list', 'ApiController@userList')->name('api.user-list');
    Route::post('/club-type-list', 'ApiController@clubTypeList')->name('api.club-type-list');
    Route::post('/club-list', 'ApiController@clubList')->name('api.club-list');
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
