<?php

namespace Codderz\Platypus\Contracts\Authorization\Abac;

interface AttributeInterface
{
    public function name(): string;

    public function value();

    public function equals($value): bool;

    public function contains($value): bool;
}
