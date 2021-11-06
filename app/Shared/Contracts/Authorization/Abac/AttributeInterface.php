<?php

namespace App\Shared\Contracts\Authorization\Abac;

interface AttributeInterface
{
    public function getName(): string;

    public function getValue();
}
