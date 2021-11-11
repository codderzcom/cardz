<?php

namespace App\Shared\Contracts\Authorization\Abac;

use App\Shared\Contracts\Authorization\AuthorizationRequestInterface;

interface AbacAuthorizationRequestInterface extends AuthorizationRequestInterface
{
    public function getPermission(): PermissionInterface;

    public function getSubject(): AttributeCollectionInterface;

    public function getObject(): AttributeCollectionInterface;

    public function getConfig(): AttributeCollectionInterface;

}
