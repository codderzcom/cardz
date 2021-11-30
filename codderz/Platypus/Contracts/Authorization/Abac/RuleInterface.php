<?php

namespace Codderz\Platypus\Contracts\Authorization\Abac;

use Codderz\Platypus\Contracts\Authorization\AuthorizationResolution;

interface RuleInterface
{
    public function forPermission(): PermissionInterface;

    public function applyPolicies(
        AttributeCollectionInterface $subject,
        AttributeCollectionInterface $object,
        AttributeCollectionInterface $config,
    ): AuthorizationResolution;
}
