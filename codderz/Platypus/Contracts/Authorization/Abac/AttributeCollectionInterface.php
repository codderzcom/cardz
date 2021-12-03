<?php

namespace Codderz\Platypus\Contracts\Authorization\Abac;

use Codderz\Platypus\Exceptions\AuthorizationFailedException;

interface AttributeCollectionInterface
{
    /** @throws AuthorizationFailedException */
    public function attr(string $attributeName): AttributeInterface;

    public function getValue(string $attributeName);

    /** @throws AuthorizationFailedException */
    public function __invoke(string $attributeName): AttributeInterface;
}
