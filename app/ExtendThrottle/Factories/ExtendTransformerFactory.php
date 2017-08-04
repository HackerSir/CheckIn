<?php

namespace App\ExtendThrottle\Factories;

use App\ExtendThrottle\Transformers\CustomKeyTransformer;
use GrahamCampbell\Throttle\Transformers\ArrayTransformer;
use GrahamCampbell\Throttle\Transformers\RequestTransformer;
use GrahamCampbell\Throttle\Transformers\TransformerFactory;
use Illuminate\Http\Request;
use InvalidArgumentException;

class ExtendTransformerFactory extends TransformerFactory
{
    /**
     * Make a new transformer instance.
     *
     * @param mixed $data
     *
     * @throws \InvalidArgumentException
     *
     * @return \GrahamCampbell\Throttle\Transformers\TransformerInterface
     */
    public function make($data)
    {
        if (is_object($data) && $data instanceof Request) {
            return new RequestTransformer();
        }

        if (is_array($data)) {
            return new ArrayTransformer();
        }

        //擴充純文字的$data
        if (is_string($data)) {
            return new CustomKeyTransformer();
        }

        throw new InvalidArgumentException('An array, string, or an instance of Illuminate\Http\Request was expected.');
    }
}
