<?php

namespace Codderz\Platypus\Contracts\Authorization\Abac;

interface AttributeInterface
{
    public function getName(): string;

    public function getValue();
}
