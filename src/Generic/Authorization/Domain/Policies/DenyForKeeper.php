<?php

namespace Cardz\Generic\Authorization\Domain\Policies;

use Codderz\Platypus\Contracts\Authorization\Abac\AttributeCollectionInterface;
use Codderz\Platypus\Contracts\Authorization\Abac\PolicyInterface;
use Codderz\Platypus\Contracts\Authorization\AuthorizationResolution;

class DenyForKeeper implements PolicyInterface
{
    public function resolve(
        AttributeCollectionInterface $subject,
        AttributeCollectionInterface $object,
        AttributeCollectionInterface $config,
    ): AuthorizationResolution {
        $subjectId = $subject->get('subjectId');
        $keeperId = $object->get('keeperId');
        return AuthorizationResolution::of($subjectId !== $keeperId);
    }
}
