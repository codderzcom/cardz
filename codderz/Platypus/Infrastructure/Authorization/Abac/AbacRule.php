<?php

namespace Codderz\Platypus\Infrastructure\Authorization\Abac;

use Codderz\Platypus\Contracts\Authorization\Abac\AttributeCollectionInterface;
use Codderz\Platypus\Contracts\Authorization\Abac\PermissionInterface;
use Codderz\Platypus\Contracts\Authorization\Abac\PolicyInterface;
use Codderz\Platypus\Contracts\Authorization\Abac\RuleInterface;
use Codderz\Platypus\Contracts\Authorization\AuthorizationResolution;

class AbacRule implements RuleInterface
{
    /** PolicyInterface[] */
    protected array $policies;

    protected function __construct(
        protected PermissionInterface $permission,
        PolicyInterface ...$policies
    ) {
        $this->policies = $policies;
    }

    public static function of(PermissionInterface $permission, PolicyInterface ...$policies)
    {
        return new static($permission, ...$policies);
    }

    public function forPermission(): PermissionInterface
    {
        return $this->permission;
    }

    public function applyPolicies(
        AttributeCollectionInterface $subject,
        AttributeCollectionInterface $object,
        AttributeCollectionInterface $config,
    ): AuthorizationResolution {
        $ruleApplicationStrategy = AbacResolutionStrategy::ofConfig($config);
        return $ruleApplicationStrategy->isPermissive()
            ? $this->applyPermissive($subject, $object, $config)
            : $this->applyRestrictive($subject, $object, $config);
    }

    protected function applyPermissive(
        AttributeCollectionInterface $subject,
        AttributeCollectionInterface $object,
        AttributeCollectionInterface $config,
    ): AuthorizationResolution {
        $resolution = AuthorizationResolution::of();
        foreach ($this->policies as $policy) {
            $resolution = $policy->resolve($subject, $object, $config);
            if ($resolution->isPermissive()) {
                return $resolution;
            }
        }
        return $resolution;
    }

    protected function applyRestrictive(
        AttributeCollectionInterface $subject,
        AttributeCollectionInterface $object,
        AttributeCollectionInterface $config,
    ): AuthorizationResolution {
        $resolution = AuthorizationResolution::of(false);
        foreach ($this->policies as $policy) {
            $resolution = $policy->resolve($subject, $object, $config);
            if ($resolution->isRestrictive()) {
                return $resolution;
            }
        }
        return $resolution;
    }
}
