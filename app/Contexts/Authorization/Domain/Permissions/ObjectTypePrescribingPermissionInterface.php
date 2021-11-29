<?php

namespace App\Contexts\Authorization\Domain\Permissions;

use App\Contexts\Authorization\Dictionary\ObjectTypeName;
use App\Shared\Contracts\Authorization\Abac\PermissionInterface;

interface ObjectTypePrescribingPermissionInterface extends PermissionInterface
{
    public function getObjectType(): ObjectTypeName;
}
