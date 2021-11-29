<?php

namespace App\Shared\Infrastructure\Authorization\Abac;

use App\Shared\Contracts\Authorization\Abac\AbacAuthorizationRequestInterface;
use App\Shared\Contracts\Authorization\Abac\RuleInterface;
use App\Shared\Contracts\Authorization\AuthorizationResolution;

class AbacEngine
{
    /** @var RuleInterface[] */
    private array $rules = [];

    public function setup(RuleInterface ...$rules): void
    {
        foreach ($rules as $rule) {
            $this->rules[(string) $rule->forPermission()] = $rule;
        }
    }

    public function resolve(AbacAuthorizationRequestInterface $authorizationRequest): AuthorizationResolution
    {
        $rule = $this->rules[(string) $authorizationRequest->getPermission()] ?? null;

        $strategy = AbacResolutionStrategy::ofConfig($authorizationRequest->getConfig());
        if ($rule === null && !$strategy->isPermissive()) {
            return AuthorizationResolution::of(false);
        }
        return $rule?->applyPolicies(
                $authorizationRequest->getSubject(),
                $authorizationRequest->getObject(),
                $authorizationRequest->getConfig(),
            ) ?? AuthorizationResolution::of();
    }
}
