<?php

namespace App\ExtendThrottle\Facades;

use Illuminate\Support\Facades\Facade;

class ExtendThrottle extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'extend-throttle';
    }
}
