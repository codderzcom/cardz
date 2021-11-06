<?php

namespace App\Contexts\Authorization\Application\Queries;

use App\Shared\Contracts\Queries\QueryInterface;

final class IsAllowed implements QueryInterface
{
    private function __construct(
        public string $action,
        public string $subjectId,
        public string $objectId,
        public string $objectType,
    ) {
    }

    public static function of(string $action, string $subjectId, string $objectId, string $objectType): self
    {
        return new self($action, $subjectId, $objectId, $objectType);
    }
}
