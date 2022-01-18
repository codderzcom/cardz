<?php

namespace Cardz\Generic\Authorization\Domain\Rules;

use Cardz\Generic\Authorization\Domain\Attribute\Attribute;
use Codderz\Platypus\Contracts\Authorization\Abac\RuleInterface;
use Codderz\Platypus\Contracts\Authorization\Abac\AttributeCollectionInterface;
use Codderz\Platypus\Contracts\Authorization\AuthorizationResolution;

class DenyForKeeper implements RuleInterface
{
    public function resolve(
        AttributeCollectionInterface $subject,
        AttributeCollectionInterface $object,
        AttributeCollectionInterface $config,
    ): AuthorizationResolution {
        $subjectId = $subject(Attribute::SUBJECT_ID)->value();
        $keeperId = $object(Attribute::KEEPER_ID)->value();

        return AuthorizationResolution::of($subjectId !== $keeperId);
    }
}
