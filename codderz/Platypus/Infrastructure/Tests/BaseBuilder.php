<?php

namespace Codderz\Platypus\Infrastructure\Tests;

use Codderz\Platypus\Contracts\Tests\BuilderInterface;
use Codderz\Platypus\Infrastructure\Support\FakerTrait;
use Faker\Factory;
use Faker\Generator;

abstract class BaseBuilder implements BuilderInterface
{
    use FakerTrait;

    public static function make(): static
    {
        $builder = new static();
        $builder->faker();
        return $builder->generate();
    }
}
