<?php

namespace Tests;

use EventSourcingLaravel\EventSourcingLaravel\EventSourcingServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [EventSourcingServiceProvider::class];
    }
}
