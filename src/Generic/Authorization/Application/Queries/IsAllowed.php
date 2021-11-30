<?php

namespace Cardz\Generic\Authorization\Application\Queries;

use Cardz\Generic\Authorization\Domain\Permissions\AuthorizationPermission;
use Codderz\Platypus\Contracts\GeneralIdInterface;
use Codderz\Platypus\Contracts\Queries\QueryInterface;

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
