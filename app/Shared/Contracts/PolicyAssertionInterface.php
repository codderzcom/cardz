<?php

namespace App\Shared\Contracts;

interface PolicyAssertionInterface
{
    public function assert(): bool;

    public function violation(): PolicyViolationInterface;
}
