<?php

namespace Codderz\Platypus\Contracts\Authorization\Abac;

interface AttributeCollectionInterface
{
    public function get(string $attributeName);
}
