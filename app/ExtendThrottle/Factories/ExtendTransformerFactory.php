<?php

namespace App\ExtendThrottle\Factories;

use App\ExtendThrottle\Transformers\CustomKeyTransformer;
use GrahamCampbell\Throttle\Transformer\ArrayTransformer;
use GrahamCampbell\Throttle\Transformer\RequestTransformer;
use GrahamCampbell\Throttle\Transformer\TransformerFactory;
use GrahamCampbell\Throttle\Transformer\TransformerInterface;
use Illuminate\Http\Request;
use InvalidArgumentException;

class ExtendTransformerFactory extends TransformerFactory
{
    /**
     * Make a new transformer instance.
     *
     * @param mixed $data
     *
     * @return TransformerInterface
     * @throws InvalidArgumentException
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
