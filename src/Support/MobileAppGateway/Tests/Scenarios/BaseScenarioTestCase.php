<?php

namespace Cardz\Support\MobileAppGateway\Tests\Scenarios;

use Cardz\Support\MobileAppGateway\Tests\Support\ScenarioRoutingTestTrait;
use Cardz\Support\MobileAppGateway\Tests\Support\ScenarioTestTrait;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
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
