<?php

namespace App\Contexts\Authorization\Domain\Policies;

use App\Shared\Contracts\Authorization\Abac\AttributeCollectionInterface;
use App\Shared\Contracts\Authorization\Abac\PolicyInterface;
use App\Shared\Contracts\Authorization\AuthorizationResolution;

class DenyForKeeper implements PolicyInterface
{
    public function resolve(
        AttributeCollectionInterface $subject,
        AttributeCollectionInterface $object,
        AttributeCollectionInterface $config,
    ): AuthorizationResolution {
        $subjectId = $subject['subjectId'] ?? null;
        $objectId = $object['id'] ?? null;
        $keeperId = $object['keeperId'] ?? null;
        $allow = $objectId !== null
            && $subjectId !== null
            && $subjectId !== $keeperId;
        return AuthorizationResolution::of($allow);
    }
}
