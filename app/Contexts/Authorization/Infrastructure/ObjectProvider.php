<?php

namespace App\Contexts\Authorization\Infrastructure;

use App\Contexts\Authorization\Dictionary\ObjectTypeName;
use App\Contexts\Authorization\Domain\AuthorizationObject;
use App\Contexts\Authorization\Domain\Permissions\ObjectTypePrescribingPermissionInterface;
use App\Contexts\Authorization\Infrastructure\ObjectProviders\CardProvider;
use App\Contexts\Authorization\Infrastructure\ObjectProviders\ConcreteObjectProviderInterface;
use App\Contexts\Authorization\Infrastructure\ObjectProviders\DefaultObjectProvider;
use App\Contexts\Authorization\Infrastructure\ObjectProviders\PlanProvider;
use App\Contexts\Authorization\Infrastructure\ObjectProviders\WorkspaceProvider;
use App\Shared\Contracts\GeneralIdInterface;

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
