<?php

namespace Codderz\Platypus\Infrastructure\Authorization\Abac;

use Codderz\Platypus\Contracts\Authorization\Abac\AuthorizationRequestInterface;
use Codderz\Platypus\Contracts\Authorization\Abac\PolicyInterface;
use Codderz\Platypus\Contracts\Authorization\AuthorizationResolution;
use Codderz\Platypus\Exceptions\AuthorizationFailedException;

class Engine
{
    /** @var PolicyInterface[] */
    private array $policies = [];

    public function setup(PolicyInterface ...$policies): void
    {
        foreach ($policies as $policy) {
            $this->policies[(string) $policy->forPermission()] = $policy;
        }
    }

    /**
     * @throws AuthorizationFailedException
     */
    public function resolve(AuthorizationRequestInterface $authorizationRequest): AuthorizationResolution
    {
        $policy = $this->policies[(string) $authorizationRequest->getPermission()] ?? null;

        $strategy = ResolutionStrategy::ofConfig($authorizationRequest->getConfig());
        return $policy?->applyRules(
                $authorizationRequest->getSubject(),
                $authorizationRequest->getObject(),
                $authorizationRequest->getConfig(),
            ) ?? AuthorizationResolution::of($strategy->isPermissive());
    }
}
