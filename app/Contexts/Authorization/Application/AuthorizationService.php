<?php

namespace App\Contexts\Authorization\Application;

use App\Contexts\Authorization\Application\Queries\IsAllowed;
use App\Contexts\Authorization\Infrastructure\ObjectProvider;
use App\Contexts\Authorization\Infrastructure\SubjectProvider;
use App\Contexts\Authorization\Rules\Workspaces\WorkspacesRuleProvider;
use App\Shared\Infrastructure\Authorization\Abac\AbacEngine;
use App\Shared\Infrastructure\Authorization\Abac\Attributes;

class AuthorizationService
{
    public function __construct(
        private ObjectProvider $objectProvider,
        private SubjectProvider $subjectProvider,
        private AbacEngine $abacEngine,

        WorkspacesRuleProvider $workspacesRuleProvider,
    ) {
        $this->abacEngine->setup(...$workspacesRuleProvider->rules);
    }

    public function isAllowed(IsAllowed $query): bool
    {
        $object = $this->objectProvider->reconstruct($query->objectType, $query->objectId);
        $subject = $this->subjectProvider->reconstruct($query->subjectId);
        $resolution = $this->abacEngine->resolve(AuthorizationRequest::of(
            $query->permission,
            $subject->getAttributes(),
            $object->getAttributes(),
            Attributes::of([])
        ));
        return !$resolution->isRestrictive();
    }
}
