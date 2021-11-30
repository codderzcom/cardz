<?php

namespace Cardz\Support\MobileAppGateway\Application\Services;

use Cardz\Generic\Authorization\Application\AuthorizationBusInterface;
use Cardz\Generic\Authorization\Application\Queries\IsAllowed;
use Cardz\Generic\Authorization\Domain\Permissions\AuthorizationPermission;
use Cardz\Support\MobileAppGateway\Application\Exceptions\AccessDeniedException;
use Codderz\Platypus\Contracts\GeneralIdInterface;

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
