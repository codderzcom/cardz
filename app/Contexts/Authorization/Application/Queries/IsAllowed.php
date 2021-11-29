<?php

namespace App\Contexts\Authorization\Application\Queries;

use App\Contexts\Authorization\Domain\Permissions\AuthorizationPermission;
use App\Shared\Contracts\GeneralIdInterface;
use App\Shared\Contracts\Queries\QueryInterface;

final class IsAllowed implements QueryInterface
{
    private function __construct(
        public AuthorizationPermission $permission,
        public GeneralIdInterface $subjectId,
        public ?GeneralIdInterface $objectId,
    ) {
    }

    public static function of(
        AuthorizationPermission $permission,
        GeneralIdInterface $subjectId,
        ?GeneralIdInterface $objectId,
    ): self {
        return new self($permission, $subjectId, $objectId);
    }
}
