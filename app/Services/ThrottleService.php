<?php

namespace App\Services;

use App\Throttle\Factories\ExtendTransformerFactory;
use GrahamCampbell\Throttle\Factories\CacheFactory;
use GrahamCampbell\Throttle\Throttle;

class ThrottleService
{
    /**
     * Get a new throttler.
     *
     * @param string|array|\Illuminate\Http\Request $data
     * @param int $limit
     * @param int $time
     * @return \GrahamCampbell\Throttle\Throttlers\ThrottlerInterface
     */
    public function get($data, $limit = 10, $time = 60)
    {
        $cache = app()->cache->driver(app()->config->get('throttle.driver'));
        //替換成擴充版的TransformerFactory
        $throttler = new Throttle(new CacheFactory($cache), new ExtendTransformerFactory());

        return $throttler->get($data, $limit, $time);
    }
}
