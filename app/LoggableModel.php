<?php

namespace App;

use App\Traits\LegacySerializeDate;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

abstract class LoggableModel extends Model
{
    use LegacySerializeDate;
    use LogsActivity;

    protected static $logName = 'loggable-model';
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
    protected static $eventText = [
        'created' => '建立了',
        'updated' => '更新了',
        'deleted' => '刪除了',
    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        return self::$eventText[$eventName] . ' ' . $this->getNameForActivityLog();
    }

    abstract protected function getNameForActivityLog(): string;
}
