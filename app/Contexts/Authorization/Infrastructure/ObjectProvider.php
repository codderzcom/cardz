<?php

namespace App\Contexts\Authorization\Infrastructure;

use App\Contexts\Authorization\Domain\AuthorizationObject;
use App\Contexts\Authorization\Infrastructure\ObjectProviders\CardProvider;
use App\Contexts\Authorization\Infrastructure\ObjectProviders\ConcreteObjectProviderInterface;
use App\Contexts\Authorization\Infrastructure\ObjectProviders\DefaultObjectProvider;
use App\Contexts\Authorization\Infrastructure\ObjectProviders\PlanProvider;
use App\Contexts\Authorization\Infrastructure\ObjectProviders\WorkspaceProvider;

class ObjectProvider
{
    public function reconstruct(string $objectType, string $objectId): AuthorizationObject
    {
        $attributes = $this->specificProvider($objectType, $objectId)->reconstruct();
        return AuthorizationObject::of($objectId, $attributes);
    }

    private function specificProvider(string $objectType, string $objectId): ConcreteObjectProviderInterface
    {
        return match ($objectType) {
            'card' => CardProvider::of($objectId),
            'plan' => PlanProvider::of($objectId),
            'workspace' => WorkspaceProvider::of($objectId),
            default => DefaultObjectProvider::of($objectId),
        };
    }
}
