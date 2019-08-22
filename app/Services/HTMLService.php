<?php

namespace App\Services;

use Purifier;

class HTMLService
{
    public function clean($richText)
    {
        //FIXME: 設定為 custom_definition 似乎會出錯
        return Purifier::clean($richText, 'test');
    }
}
