<?php

namespace Cardz\Generic\Authorization\Domain\Rules;

use Codderz\Platypus\Contracts\Authorization\Abac\RuleInterface;
use Codderz\Platypus\Contracts\Authorization\Abac\AttributeCollectionInterface;
use Codderz\Platypus\Contracts\Authorization\AuthorizationResolution;

class AllowForEveryone implements RuleInterface
{
    public function resolve(
        AttributeCollectionInterface $subject,
        AttributeCollectionInterface $object,
        AttributeCollectionInterface $config,
    ): AuthorizationResolution {
        return AuthorizationResolution::ALLOW();
    }
}
