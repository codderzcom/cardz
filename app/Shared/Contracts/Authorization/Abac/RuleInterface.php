<?php

namespace App\Shared\Contracts\Authorization\Abac;

interface RuleInterface
{
    public function getPolicies(): array;

    public function getPermission(): PermissionInterface;
}
