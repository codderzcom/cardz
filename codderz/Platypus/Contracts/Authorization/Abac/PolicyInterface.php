<?php

namespace Codderz\Platypus\Contracts\Authorization\Abac;

use Codderz\Platypus\Contracts\Authorization\AuthorizationResolution;
use Codderz\Platypus\Exceptions\AuthorizationFailedException;

interface PolicyInterface
{
    public function forPermission(): PermissionInterface;

    /** @throws AuthorizationFailedException */
    public function applyRules(
        AttributeCollectionInterface $subject,
        AttributeCollectionInterface $object,
        AttributeCollectionInterface $config,
    ): AuthorizationResolution;
}
