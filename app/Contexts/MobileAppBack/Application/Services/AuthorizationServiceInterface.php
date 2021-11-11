<?php

namespace App\Contexts\MobileAppBack\Application\Services;

use App\Contexts\Authorization\Domain\AuthorizationObjectType;
use App\Shared\Contracts\GeneralIdInterface;
use App\Shared\Infrastructure\Authorization\Abac\AbacPermission;

interface AuthorizationServiceInterface
{
    public function authorize(
        AbacPermission $permission,
        AuthorizationObjectType $objectType,
        GeneralIdInterface $subjectId,
        GeneralIdInterface $objectId,
    ): void;
}
