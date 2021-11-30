<?php

namespace Codderz\Platypus\Infrastructure\Tests;

use Codderz\Platypus\Contracts\Tests\BuilderInterface;
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
