<?php

namespace Codderz\Platypus\Contracts\Authorization\Abac;

use Codderz\Platypus\Contracts\Authorization\AuthorizationRequestInterface;

interface AbacAuthorizationRequestInterface extends AuthorizationRequestInterface
{
    public function getPermission(): PermissionInterface;

    public function getSubject(): AttributeCollectionInterface;

    public function getObject(): AttributeCollectionInterface;

    public function getConfig(): AttributeCollectionInterface;

}
