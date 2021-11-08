<?php

namespace App\Contexts\Authorization\Application\Queries;

use App\Shared\Contracts\Queries\QueryInterface;

final class IsAllowed implements QueryInterface
{
    private function __construct(
        public string $permission,
        public string $subjectId,
        public string $objectId,
        public string $objectType,
    ) {
    }

    public static function of(string $permission, string $subjectId, string $objectId, string $objectType): self
    {
        return new self($permission, $subjectId, $objectId, $objectType);
    }
}
