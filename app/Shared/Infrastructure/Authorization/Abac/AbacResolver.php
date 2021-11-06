<?php

namespace App\Shared\Infrastructure\Authorization\Abac;

use App\Shared\Contracts\Authorization\Abac\AbacResolverInterface;
use App\Shared\Contracts\Authorization\Abac\AttributeCollectionInterface;
use App\Shared\Contracts\Authorization\Abac\RuleInterface;
use App\Shared\Contracts\Authorization\AuthorizationResolution;

class AbacResolver implements AbacResolverInterface
{
    public function resolve(
        AttributeCollectionInterface $subjectAttributes,
        AttributeCollectionInterface $objectAttributes,
        AttributeCollectionInterface $configAttributes,
        RuleInterface $rule,
    ): AuthorizationResolution {
        $policies = $rule->getPolicies();
        $allows = null;
        foreach ($policies as $policy) {
            $allows = $allows && $policy->apply($subjectAttributes, $objectAttributes, $configAttributes);
            if ($allows === false) {
                return AuthorizationResolution::of($allows);
            }
        }
        return AuthorizationResolution::of($allows);
    }

}
