<?php

namespace App\Contexts\MobileAppBack\Application\Services;

use App\Contexts\Authorization\Application\AuthorizationBusInterface;
use App\Contexts\Authorization\Application\Queries\IsAllowed;
use App\Contexts\Authorization\Domain\Permissions\AuthorizationPermission;
use App\Contexts\MobileAppBack\Application\Exceptions\AccessDeniedException;
use App\Shared\Contracts\GeneralIdInterface;

class AuthorizationService implements AuthorizationServiceInterface
{
    public function __construct(
        private AuthorizationBusInterface $authorizationBus,
    ) {
    }

    public function authorize(
        AuthorizationPermission $permission,
        GeneralIdInterface $subjectId,
        ?GeneralIdInterface $objectId,
    ): void {
        $isAllowed = $this->authorizationBus->execute(IsAllowed::of($permission, $subjectId, $objectId));
        if (!$isAllowed) {
            throw new AccessDeniedException("Access denied");
        }
    }
}
