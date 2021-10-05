<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Create a model factory and forget observers so events do not trigger actions.
     *
     * @param  Model|string  $class
     */
    public function factoryWithoutObservers($class)
    {
        $class::flushEventListeners();

        return call_user_func([$class, 'factory']);
    }
}
