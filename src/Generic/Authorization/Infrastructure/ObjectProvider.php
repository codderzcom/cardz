<?php

namespace Cardz\Generic\Authorization\Infrastructure;

use Cardz\Generic\Authorization\Dictionary\ObjectTypeName;
use Cardz\Generic\Authorization\Domain\AuthorizationObject;
use Cardz\Generic\Authorization\Domain\Permissions\ObjectTypePrescribingPermissionInterface;
use Cardz\Generic\Authorization\Infrastructure\ObjectProviders\CardProvider;
use Cardz\Generic\Authorization\Infrastructure\ObjectProviders\ConcreteObjectProviderInterface;
use Cardz\Generic\Authorization\Infrastructure\ObjectProviders\DefaultObjectProvider;
use Cardz\Generic\Authorization\Infrastructure\ObjectProviders\PlanProvider;
use Cardz\Generic\Authorization\Infrastructure\ObjectProviders\WorkspaceProvider;
use Codderz\Platypus\Contracts\GeneralIdInterface;

class ObjectProvider
{
    public function reconstructForPermission(
        ?GeneralIdInterface $objectId,
        ObjectTypePrescribingPermissionInterface $permission
    ): AuthorizationObject {
        $objectType = $permission->getObjectType();
        $attributes = $this->specificProvider($objectId, $objectType)->reconstruct();
        return AuthorizationObject::of($objectId, $attributes);
    }

    private function specificProvider(?GeneralIdInterface $objectId, ObjectTypeName $objectType): ConcreteObjectProviderInterface
    {
        return match ($objectType->getValue()) {
            ObjectTypeName::CARD => CardProvider::of($objectId),
            ObjectTypeName::PLAN => PlanProvider::of($objectId),
            ObjectTypeName::WORKSPACE => WorkspaceProvider::of($objectId),
            default => DefaultObjectProvider::of($objectId),
        };
    }
}
