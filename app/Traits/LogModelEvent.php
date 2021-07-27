<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;

trait LogModelEvent
{
    use LogsActivity {
        getLogNameToUse as originalGetLogNameToUse;
    }

    protected static $logName = 'loggable-model';
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $eventText = [
        'created' => '建立了',
        'updated' => '更新了',
        'deleted' => '刪除了',
    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        return self::$eventText[$eventName] . ' ' . $this->getNameForActivityLog();
    }

    protected function getNameForActivityLog(): string
    {
        return substr(strrchr(__CLASS__, '\\'), 1);
    }

    public function getLogNameToUse(string $eventName = ''): string
    {
        $logNameFromClassName = substr(strrchr(__CLASS__, '\\'), 1);
        if (!empty($logNameFromClassName)) {
            return Str::kebab($logNameFromClassName);
        }

        return $this->originalGetLogNameToUse($eventName);
    }
}
