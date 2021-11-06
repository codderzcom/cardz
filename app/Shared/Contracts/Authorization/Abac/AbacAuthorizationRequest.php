<?php

namespace App\Shared\Contracts\Authorization\Abac;

use App\Shared\Contracts\Authorization\AuthorizationRequest;

interface AbacAuthorizationRequest extends AuthorizationRequest
{
    public function getSubjectAttributes(): AttributeCollectionInterface;

    public function getObjectAttributes(): AttributeCollectionInterface;

    public function getConfigAttributes(): AttributeCollectionInterface;

    public function getPermission(): PermissionInterface;
}
