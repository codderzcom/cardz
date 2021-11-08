<?php

namespace App\Shared\Contracts\Authorization\Abac;

use App\Shared\Contracts\Authorization\AuthorizationResolution;

interface PolicyInterface
{
    public function resolve(
        AttributeCollectionInterface $subject,
        AttributeCollectionInterface $object,
        AttributeCollectionInterface $config,
    ): AuthorizationResolution;
}
