<?php

namespace Cardz\Generic\Authorization\Domain\Policies;

use Codderz\Platypus\Contracts\Authorization\Abac\AttributeCollectionInterface;
use Codderz\Platypus\Contracts\Authorization\Abac\PolicyInterface;
use Codderz\Platypus\Contracts\Authorization\AuthorizationResolution;

class AllowForKeeper implements PolicyInterface
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
            && $subjectId === $keeperId;
        return AuthorizationResolution::of($allow);
    }
}
