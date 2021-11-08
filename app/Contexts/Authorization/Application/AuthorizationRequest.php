<?php

namespace App\Contexts\Authorization\Application;

use App\Shared\Contracts\Authorization\Abac\AbacAuthorizationRequestInterface;
use App\Shared\Contracts\Authorization\Abac\AttributeCollectionInterface;
use App\Shared\Contracts\Authorization\Abac\PermissionInterface;

final class AuthorizationRequest implements AbacAuthorizationRequestInterface
{
    private function __construct(
        private PermissionInterface $permission,
        private AttributeCollectionInterface $subject,
        private AttributeCollectionInterface $object,
        private AttributeCollectionInterface $config,
    ) {
    }

    public static function of(
        PermissionInterface $permission,
        AttributeCollectionInterface $subject,
        AttributeCollectionInterface $object,
        AttributeCollectionInterface $config,
    ): self {
        return new self($permission, $subject, $object, $config);
    }

    public function getPermission(): PermissionInterface
    {
        return $this->permission;
    }

    public function getSubject(): AttributeCollectionInterface
    {
        return $this->subject;
    }

    public function getObject(): AttributeCollectionInterface
    {
        return $this->object;
    }

    public function getConfig(): AttributeCollectionInterface
    {
        return $this->config;
    }

}
