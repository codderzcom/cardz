<?php

namespace App\Shared\Infrastructure\Authorization\Abac;

use App\Shared\Contracts\Authorization\Abac\PermissionInterface;

class AbacPermission implements PermissionInterface
{
    private function __construct(
        private string $permission,
    ) {
    }

    public static function of(string $permission): static
    {
        return new static($permission);
    }

    public function __toString(): string
    {
        return $this->permission;
    }
}
