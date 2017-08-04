<?php

namespace App\ExtendThrottle\Transformers;

use GrahamCampbell\Throttle\Data;
use GrahamCampbell\Throttle\Transformers\TransformerInterface;

class CustomKeyTransformer implements TransformerInterface
{
    /**
     * Transform the data into a new data instance.
     *
     * @param string $data
     * @param int $limit
     * @param int $time
     *
     * @return \GrahamCampbell\Throttle\Data
     */
    public function transform($data, $limit = 10, $time = 60)
    {
        return new Data((string) $data, (string) 'static fake route', (int) $limit, (int) $time);
    }
}
