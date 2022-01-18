<?php

namespace Cardz\Generic\Authorization\Application;

use Codderz\Platypus\Contracts\Authorization\Abac\AuthorizationRequestInterface;
use Codderz\Platypus\Contracts\Authorization\Abac\AttributeCollectionInterface;
use Codderz\Platypus\Contracts\Authorization\Abac\PermissionInterface;
use JetBrains\PhpStorm\Pure;

final class AuthorizationRequest implements AuthorizationRequestInterface
{
    private function __construct(
        private PermissionInterface $permission,
        private AttributeCollectionInterface $subject,
        private AttributeCollectionInterface $object,
        private AttributeCollectionInterface $config,
    ) {
    }

    #[Pure]
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
