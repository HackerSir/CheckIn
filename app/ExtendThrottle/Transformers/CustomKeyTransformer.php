<?php

namespace App\ExtendThrottle\Transformers;

use GrahamCampbell\Throttle\Data;
use GrahamCampbell\Throttle\Transformer\TransformerInterface;

class CustomKeyTransformer implements TransformerInterface
{
    /**
     * Transform the data into a new data instance.
     *
     * @param string $data
     * @param int $limit
     * @param int $time
     *
     * @return Data
     */
    public function transform($data, int $limit = 10, int $time = 60)
    {
        return new Data((string) $data, (string) 'static fake route', (int) $limit, (int) $time);
    }
}
