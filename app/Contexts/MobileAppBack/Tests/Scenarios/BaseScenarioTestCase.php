<?php

namespace App\Contexts\MobileAppBack\Tests\Scenarios;

use App\Contexts\MobileAppBack\Tests\Support\ScenarioRoutingTestTrait;
use App\Contexts\MobileAppBack\Tests\Support\ScenarioTestTrait;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class BaseScenarioTestCase extends TestCase
{
    use RefreshDatabase, MakesHttpRequests, ApplicationTestTrait, ScenarioTestTrait, ScenarioRoutingTestTrait;

    protected Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->setUpEnvironment();
    }
}
