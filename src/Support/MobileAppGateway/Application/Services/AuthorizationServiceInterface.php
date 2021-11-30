<?php

namespace Cardz\Support\MobileAppGateway\Application\Services;

use Cardz\Generic\Authorization\Domain\Permissions\AuthorizationPermission;
use Codderz\Platypus\Contracts\GeneralIdInterface;

interface AuthorizationServiceInterface
{
    public function authorize(
        AuthorizationPermission $permission,
        GeneralIdInterface $subjectId,
        ?GeneralIdInterface $objectId,
    ): void;
}
