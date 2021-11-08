<?php

namespace App\Shared\Contracts\Authorization\Abac;

use App\Shared\Contracts\Authorization\AuthorizationResolution;

interface RuleInterface
{
    public function forPermission(): PermissionInterface;

    public function applyPolicies(
        AttributeCollectionInterface $subject,
        AttributeCollectionInterface $object,
        AttributeCollectionInterface $config,
    ): AuthorizationResolution;
}
