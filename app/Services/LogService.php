<?php

namespace App\Services;

use App;
use Log;
use Monolog\Logger as MonologLogger;

/**
 * Class LogService
 *
 * @method null debug($message, $data1 = null, $data2 = null, $data3 = null, $data4 = null, $data5 = null)
 * @method null info($message, $data1 = null, $data2 = null, $data3 = null, $data4 = null, $data5 = null)
 * @method null notice($message, $data1 = null, $data2 = null, $data3 = null, $data4 = null, $data5 = null)
 * @method null warning($message, $data1 = null, $data2 = null, $data3 = null, $data4 = null, $data5 = null)
 * @method null error($message, $data1 = null, $data2 = null, $data3 = null, $data4 = null, $data5 = null)
 * @method null critical($message, $data1 = null, $data2 = null, $data3 = null, $data4 = null, $data5 = null)
 * @method null alert($message, $data1 = null, $data2 = null, $data3 = null, $data4 = null, $data5 = null)
 * @method null emergency($message, $data1 = null, $data2 = null, $data3 = null, $data4 = null, $data5 = null)
 */
class LogService
{
    /**
     * The Log levels.
     *
     * @var array
     */
    protected static $levels = [
        'debug'     => MonologLogger::DEBUG,
        'info'      => MonologLogger::INFO,
        'notice'    => MonologLogger::NOTICE,
        'warning'   => MonologLogger::WARNING,
        'error'     => MonologLogger::ERROR,
        'critical'  => MonologLogger::CRITICAL,
        'alert'     => MonologLogger::ALERT,
        'emergency' => MonologLogger::EMERGENCY,
    ];

    protected static $jsonOptions =
        JSON_UNESCAPED_UNICODE              //不跳脫Unicode字元
        + JSON_UNESCAPED_SLASHES;            //不跳脫斜線

    /**
     * Log an message to the logs.
     *
     * @param string $level
     * @param string $arguments
     * @return void
     */
    public function __call($level, $arguments)
    {
        //測試環境不處理
        if (app()->environment('testing')) {
            return;
        }
        //只處理有效層級的紀錄
        if (!in_array($level, array_keys(static::$levels))) {
            return;
        }

        $contextList = func_get_arg(1);
        $message = '';
        foreach ($contextList as $context) {
            if (is_string($context)) {
                $temp = $context;
            } else {
                $temp = json_encode($context, static::$jsonOptions);
            }
            $message .= $temp . PHP_EOL;
        }
        Log::$level($message);
    }
}
