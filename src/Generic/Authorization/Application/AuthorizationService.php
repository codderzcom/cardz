<?php

namespace Cardz\Generic\Authorization\Application;

use Cardz\Generic\Authorization\Application\Queries\IsAllowed;
use Cardz\Generic\Authorization\Domain\Attribute\Attributes;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Cardz\Generic\Authorization\Domain\Rules\RuleConfig;
use Cardz\Generic\Authorization\Infrastructure\ResourceProviderInterface;
use Codderz\Platypus\Infrastructure\Authorization\Abac\AbacEngine;
use Codderz\Platypus\Infrastructure\Authorization\Abac\AbacResolutionStrategy;

class AuthorizationService
{
    public function __construct(
        private AbacEngine $abacEngine,
        private ResourceProviderInterface $resourceProvider,
    ) {
        $this->abacEngine->setup(...RuleConfig::make()->getRules());
    }

    public function isAllowed(IsAllowed $query): bool
    {
        $objectAttributes = $this->resourceProvider->getResourceAttributes($query->objectId, $query->permission->resourceType());
        $subjectAttributes = $this->resourceProvider->getResourceAttributes($query->subjectId, ResourceType::SUBJECT());

        $resolution = $this->abacEngine->resolve(AuthorizationRequest::of(
            $query->permission,
            $subjectAttributes,
            $objectAttributes,
            Attributes::of(['abac.strategy' => AbacResolutionStrategy::RESTRICTIVE])
        ));
        return !$resolution->isRestrictive();
    }
}
