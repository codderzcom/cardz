<?php

namespace Codderz\Platypus\Contracts\Tests;

interface BuilderInterface
{
    public function build();

    public function generate(): static;
}
