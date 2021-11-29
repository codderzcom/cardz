<?php

namespace App\Shared\Infrastructure\Tests;

use App\Shared\Contracts\Tests\BuilderInterface;
use Faker\Factory;
use Faker\Generator;

abstract class BaseBuilder implements BuilderInterface
{
    public Generator $faker;

    public static function make(): static
    {
        $builder = new static();
        $builder->faker = Factory::create();
        return $builder->generate();
    }
}
