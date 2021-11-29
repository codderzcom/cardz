<?php

namespace App\Contexts\Authorization\Application;

use App\Contexts\Authorization\Application\Queries\IsAllowed;
use App\Contexts\Authorization\Domain\Rules\RuleConfig;
use App\Contexts\Authorization\Infrastructure\ObjectProvider;
use App\Contexts\Authorization\Infrastructure\SubjectProvider;
use App\Shared\Infrastructure\Authorization\Abac\AbacEngine;
use App\Shared\Infrastructure\Authorization\Abac\AbacResolutionStrategy;
use App\Shared\Infrastructure\Authorization\Abac\Attributes;

class AuthorizationService
{
    public function __construct(
        private ObjectProvider $objectProvider,
        private SubjectProvider $subjectProvider,
        private AbacEngine $abacEngine,
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
