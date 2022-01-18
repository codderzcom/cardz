<?php

namespace Codderz\Platypus\Contracts\Authorization\Abac;

use Codderz\Platypus\Contracts\Authorization\AuthorizationResolution;
use Codderz\Platypus\Exceptions\AuthorizationFailedException;

interface RuleInterface
{
    /** @throws AuthorizationFailedException */
    public function resolve(
        AttributeCollectionInterface $subject,
        AttributeCollectionInterface $object,
        AttributeCollectionInterface $config,
    ): AuthorizationResolution;
}
