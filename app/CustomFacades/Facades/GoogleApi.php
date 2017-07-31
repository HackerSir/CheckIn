<?php

namespace App\CustomFacades\Facades;

use Illuminate\Support\Facades\Facade;

class GoogleApi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'google-api';
    }
}
