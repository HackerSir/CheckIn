<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Create a model factory and forget observers so events do not trigger actions.
     * @param Model|string $class
     * @param string $name
     * @return \Illuminate\Database\Eloquent\FactoryBuilder
     */
    public function factoryWithoutObservers($class, $name = null)
    {
        $class::flushEventListeners();

        return factory($class, $name);
    }
}
