<?php

namespace App\Contexts\MobileAppBack\Application\Services;

interface AuthorizationServiceInterface
{
    public function authorizeAction(string $action, string $subjectId, string $objectId, string $objectType): void;
}
