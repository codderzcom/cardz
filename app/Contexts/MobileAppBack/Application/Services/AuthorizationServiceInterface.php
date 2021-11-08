<?php

namespace App\Contexts\MobileAppBack\Application\Services;

interface AuthorizationServiceInterface
{
    public function authorizeAction(string $permission, string $subjectId, string $objectId, string $objectType): void;
}
