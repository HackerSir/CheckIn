<?php

namespace App\ExtendThrottle;

use App\ExtendThrottle\Factories\ExtendTransformerFactory;
use GrahamCampbell\Throttle\Factory\CacheFactory;
use GrahamCampbell\Throttle\Throttle;
use GrahamCampbell\Throttle\Throttler\ThrottlerInterface;
use Illuminate\Http\Request;

class ExtendThrottle
{
    /**
     * Get a new throttler.
     *
     * @param  string|array|Request  $data
     * @param  int  $limit
     * @param  int  $time
     * @return ThrottlerInterface
     */
    public function get($data, $limit = 10, $time = 60)
    {
        $cache = app()->cache->driver(app()->config->get('throttle.driver'));
        //替換成擴充版的TransformerFactory
        $throttler = new Throttle(new CacheFactory($cache), new ExtendTransformerFactory());

        return $throttler->get($data, $limit, $time);
    }
}
