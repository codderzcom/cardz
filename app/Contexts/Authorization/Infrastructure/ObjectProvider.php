<?php

namespace App\Contexts\Authorization\Infrastructure;

use App\Contexts\Authorization\Domain\AuthorizationObject;
use App\Contexts\Authorization\Domain\AuthorizationObjectType;
use App\Contexts\Authorization\Infrastructure\ObjectProviders\CardProvider;
use App\Contexts\Authorization\Infrastructure\ObjectProviders\ConcreteObjectProviderInterface;
use App\Contexts\Authorization\Infrastructure\ObjectProviders\DefaultObjectProvider;
use App\Contexts\Authorization\Infrastructure\ObjectProviders\PlanProvider;
use App\Contexts\Authorization\Infrastructure\ObjectProviders\WorkspaceProvider;
use App\Shared\Contracts\GeneralIdInterface;

class ObjectProvider
{
    public function reconstruct(AuthorizationObjectType $objectType, GeneralIdInterface $objectId): AuthorizationObject
    {
        $attributes = $this->specificProvider($objectType, $objectId)->reconstruct();
        return AuthorizationObject::of($objectId, $attributes);
    }

    private function specificProvider(AuthorizationObjectType $objectType, GeneralIdInterface $objectId): ConcreteObjectProviderInterface
    {
        return match ($objectType->getValue()) {
            AuthorizationObjectType::CARD => CardProvider::of($objectId),
            AuthorizationObjectType::PLAN => PlanProvider::of($objectId),
            AuthorizationObjectType::WORKSPACE => WorkspaceProvider::of($objectId),
            default => DefaultObjectProvider::of($objectId),
        };
    }
}
