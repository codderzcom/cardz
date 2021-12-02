<?php

namespace Cardz\Generic\Authorization\Application;

use Cardz\Generic\Authorization\Application\Queries\IsAllowed;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Cardz\Generic\Authorization\Domain\Rules\RuleConfig;
use Cardz\Generic\Authorization\Infrastructure\ObjectProvider;
use Cardz\Generic\Authorization\Infrastructure\ResourceProviderInterface;
use Cardz\Generic\Authorization\Infrastructure\SubjectProvider;
use Codderz\Platypus\Infrastructure\Authorization\Abac\AbacEngine;
use Codderz\Platypus\Infrastructure\Authorization\Abac\AbacResolutionStrategy;
use Codderz\Platypus\Infrastructure\Authorization\Abac\Attributes;

class AuthorizationService
{
    public function __construct(
        private ObjectProvider $objectProvider,
        private SubjectProvider $subjectProvider,
        private AbacEngine $abacEngine,
        private ResourceProviderInterface $resourceProvider,
    ) {
        $this->abacEngine->setup(...RuleConfig::make()->getRules());
    }

    public function isAllowed(IsAllowed $query): bool
    {
        $object = $this->objectProvider->reconstructForPermission($query->objectId, $query->permission);
        $subject = $this->subjectProvider->reconstruct($query->subjectId);
        $resolution = $this->abacEngine->resolve(AuthorizationRequest::of(
            $query->permission,
            $subject->getAttributes(),
            $object->getAttributes(),
            Attributes::of(['abac.strategy' => AbacResolutionStrategy::RESTRICTIVE])
        ));
        return !$resolution->isRestrictive();
    }
}
