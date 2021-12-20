<?php

namespace Codderz\Platypus\Infrastructure\Support;

use Faker\Factory;
use Faker\Generator;

trait FakerTrait
{
    protected Generator $faker;

    public function faker(): Generator
    {
        return $this->faker ??= Factory::create();
    }

}
