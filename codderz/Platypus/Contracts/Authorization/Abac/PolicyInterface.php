<?php

namespace Codderz\Platypus\Contracts\Authorization\Abac;

use Codderz\Platypus\Contracts\Authorization\AuthorizationResolution;

interface PolicyInterface
{
    public function resolve(
        AttributeCollectionInterface $subject,
        AttributeCollectionInterface $object,
        AttributeCollectionInterface $config,
    ): AuthorizationResolution;
}
