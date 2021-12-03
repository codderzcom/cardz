<?php

namespace Cardz\Generic\Authorization\Domain\Policies;

use Cardz\Generic\Authorization\Domain\Attribute\Attribute;
use Codderz\Platypus\Contracts\Authorization\Abac\AttributeCollectionInterface;
use Codderz\Platypus\Contracts\Authorization\Abac\PolicyInterface;
use Codderz\Platypus\Contracts\Authorization\AuthorizationResolution;

class AllowForCollaborators implements PolicyInterface
{
    public function resolve(
        AttributeCollectionInterface $subject,
        AttributeCollectionInterface $object,
        AttributeCollectionInterface $config,
    ): AuthorizationResolution {
        $subjectId = $subject(Attribute::SUBJECT_ID)->value();

        return AuthorizationResolution::of($object(Attribute::MEMBER_IDS)->contains($subjectId));
    }
}
