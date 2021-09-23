<?php

namespace App\Contexts\Shared\Contracts;

interface PolicyAssertionInterface
{
    public function assert(): bool;

    public function violation(): ?PolicyViolationInterface;
}
