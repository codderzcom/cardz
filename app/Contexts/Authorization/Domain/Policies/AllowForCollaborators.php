<?php

namespace App\Contexts\Authorization\Domain\Policies;

use App\Shared\Contracts\Authorization\Abac\AttributeCollectionInterface;
use App\Shared\Contracts\Authorization\Abac\PolicyInterface;
use App\Shared\Contracts\Authorization\AuthorizationResolution;

class AllowForCollaborators implements PolicyInterface
{
    public function resolve(
        AttributeCollectionInterface $subject,
        AttributeCollectionInterface $object,
        AttributeCollectionInterface $config,
    ): AuthorizationResolution {
        $subjectId = $subject['subjectId'] ?? null;
        $objectId = $object['id'] ?? null;
        $memberIds = $object['memberIds'] ?? [];
        $keeperId = $object['keeperId'] ?? null;
        $allow = $objectId !== null
            && $subjectId !== null
            && ($subjectId === $keeperId || in_array($subjectId, $memberIds, true));
        return AuthorizationResolution::of($allow);
    }
}
