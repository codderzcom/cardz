<?php

namespace App\Contexts\MobileAppBack\Application\Services;

use App\Contexts\Authorization\Application\AuthorizationBusInterface;
use App\Contexts\Authorization\Application\Queries\IsAllowed;
use App\Contexts\MobileAppBack\Application\Exceptions\AccessDeniedException;

class AuthorizationService implements AuthorizationServiceInterface
{
    public function __construct(
        private AuthorizationBusInterface $authorizationBus,
    ) {
    }

    public function authorizeAction(string $action, string $subjectId, string $objectId, string $objectType): void
    {
        $isAllowed = $this->authorizationBus->execute(IsAllowed::of($action, $subjectId, $objectId, $objectType));
        if (!$isAllowed) {
            throw new AccessDeniedException("Access denied");
        }
    }
}
