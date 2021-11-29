<?php

namespace App\Contexts\MobileAppBack\Application\Services;

use App\Contexts\Authorization\Domain\Permissions\AuthorizationPermission;
use App\Shared\Contracts\GeneralIdInterface;

interface AuthorizationServiceInterface
{
    public function authorize(
        AuthorizationPermission $permission,
        GeneralIdInterface $subjectId,
        ?GeneralIdInterface $objectId,
    ): void;
}
