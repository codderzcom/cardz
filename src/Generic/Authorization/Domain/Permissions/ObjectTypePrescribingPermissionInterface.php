<?php

namespace Cardz\Generic\Authorization\Domain\Permissions;

use Cardz\Generic\Authorization\Dictionary\ObjectTypeName;
use Codderz\Platypus\Contracts\Authorization\Abac\PermissionInterface;

interface ObjectTypePrescribingPermissionInterface extends PermissionInterface
{
    public function getObjectType(): ObjectTypeName;
}
