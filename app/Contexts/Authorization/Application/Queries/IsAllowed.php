<?php

namespace App\Contexts\Authorization\Application\Queries;

use App\Contexts\Authorization\Domain\AuthorizationObjectType;
use App\Shared\Contracts\GeneralIdInterface;
use App\Shared\Contracts\Queries\QueryInterface;
use App\Shared\Infrastructure\Authorization\Abac\AbacPermission;

final class IsAllowed implements QueryInterface
{
    private function __construct(
        public AbacPermission $permission,
        public GeneralIdInterface $subjectId,
        public GeneralIdInterface $objectId,
        public AuthorizationObjectType $objectType,
    ) {
    }

    public static function of(
        AbacPermission $permission,
        GeneralIdInterface $subjectId,
        GeneralIdInterface $objectId,
        AuthorizationObjectType $objectType
    ): self {
        return new self($permission, $subjectId, $objectId, $objectType);
    }
}
