<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class FeatureTestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    public function shouldHaveCalledAction(string $actionName, ?callable $callable): void
    {
        if (is_callable($callable))
        {
            $callable();
        }
        $original = $this->app->make($actionName);

        $this->mock($actionName)
             ->expects('run')
             ->atLeast()->once()
             ->andReturnUsing(fn(...$args) => $original->run(...$args));
    }
}
