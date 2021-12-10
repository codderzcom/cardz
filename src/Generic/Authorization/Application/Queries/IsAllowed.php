<?php

namespace Cardz\Generic\Authorization\Application\Queries;

use Cardz\Generic\Authorization\Domain\Permissions\AuthorizationPermission;
use Codderz\Platypus\Contracts\GenericIdInterface;
use Codderz\Platypus\Contracts\Queries\QueryInterface;

final class IsAllowed implements QueryInterface
{
    private function __construct(
        public AuthorizationPermission $permission,
        public GenericIdInterface $subjectId,
        public ?GenericIdInterface $objectId,
    ) {
    }

    public static function of(
        AuthorizationPermission $permission,
        GenericIdInterface $subjectId,
        ?GenericIdInterface $objectId,
    ): self {
        return new self($permission, $subjectId, $objectId);
    }
}
