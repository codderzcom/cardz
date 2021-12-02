<?php

namespace Codderz\Platypus\Infrastructure\Authorization\Abac;

use Codderz\Platypus\Contracts\Authorization\Abac\AbacAuthorizationRequestInterface;
use Codderz\Platypus\Contracts\Authorization\Abac\RuleInterface;
use Codderz\Platypus\Contracts\Authorization\AuthorizationResolution;

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
        return $rule?->applyPolicies(
                $authorizationRequest->getSubject(),
                $authorizationRequest->getObject(),
                $authorizationRequest->getConfig(),
            ) ?? AuthorizationResolution::of($strategy->isPermissive());
    }
}
