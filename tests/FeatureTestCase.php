<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class FeatureTestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    public function shouldHaveCalledAction(string $actionName): void
    {
        $original = $this->app->make($actionName);

        $this->mock($actionName)
             ->expects('run')
             ->atLeast()->once()
             ->andReturnUsing(fn(...$args) => $original->run(...$args));
    }
}