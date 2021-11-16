<?php

namespace App\Shared\Infrastructure\Tests;

use App\Shared\Contracts\Commands\CommandBusInterface;
use Tests\TestCase;

abstract class BaseTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        //$this->app->singleton(CommandBusInterface::class, TestCommandBus::class);
    }

}
