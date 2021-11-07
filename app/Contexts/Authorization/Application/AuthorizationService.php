<?php

namespace App\Contexts\Authorization\Application;

use App\Contexts\Authorization\Application\Queries\IsAllowed;
use App\Contexts\Authorization\Infrastructure\ObjectProvider;
use App\Contexts\Authorization\Infrastructure\SubjectProvider;
use App\Contexts\Authorization\Policies\Authorizer;

class AuthorizationService
{
    public function __construct(
        private ObjectProvider $objectProvider,
        private SubjectProvider $subjectProvider,
        private Authorizer $authorizer,
    ) {
    }

    public function isAllowed(IsAllowed $query): bool
    {
        $object = $this->objectProvider->reconstruct($query->objectType, $query->objectId);
        $subject = $this->subjectProvider->reconstruct($query->subjectId);
        $resolution = $this->authorizer->resolve($query->action, $subject, $object);
        return $resolution->isPermissive();
    }
}
