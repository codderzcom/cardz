<?php

namespace App\Shared\Contracts\Authorization\Abac;

use App\Shared\Contracts\Authorization\AuthorizationResolution;

interface AbacResolverInterface
{
    public function resolve(
        AttributeCollectionInterface $subjectAttributes,
        AttributeCollectionInterface $objectAttributes,
        AttributeCollectionInterface $configAttributes,
        RuleInterface $rule,
    ): AuthorizationResolution;
}
