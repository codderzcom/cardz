<?php

namespace Cardz\Generic\Authorization\Application;

use Cardz\Generic\Authorization\Application\Queries\IsAllowed;
use Cardz\Generic\Authorization\Domain\Attribute\Attributes;
use Cardz\Generic\Authorization\Domain\Policies\PolicyConfig;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Cardz\Generic\Authorization\Infrastructure\ResourceProviderInterface;
use Codderz\Platypus\Infrastructure\Authorization\Abac\Engine;
use Codderz\Platypus\Infrastructure\Authorization\Abac\ResolutionStrategy;

class AuthorizationService
{
    public function __construct(
        private Engine $engine,
        private ResourceProviderInterface $resourceProvider,
    ) {
        $this->engine->setup(...PolicyConfig::make()->getPolicies());
    }

    public function isAllowed(IsAllowed $query): bool
    {
        $objectAttributes = $this->resourceProvider->getResourceAttributes($query->objectId, $query->permission->resourceType());
        $subjectAttributes = $this->resourceProvider->getResourceAttributes($query->subjectId, ResourceType::SUBJECT());

        $resolution = $this->engine->resolve(AuthorizationRequest::of(
            $query->permission,
            $subjectAttributes,
            $objectAttributes,
            Attributes::of([ResolutionStrategy::class => ResolutionStrategy::RESTRICTIVE])
        ));
        return !$resolution->isRestrictive();
    }
}
