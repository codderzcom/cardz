<?php

namespace App\Shared\Contracts\Tests;

interface BuilderInterface
{
    public function build();

    public function generate(): static;
}
