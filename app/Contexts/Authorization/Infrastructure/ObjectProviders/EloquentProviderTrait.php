<?php

namespace App\Contexts\Authorization\Infrastructure\ObjectProviders;

use App\Shared\Exceptions\AuthorizationFailedException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait EloquentProviderTrait
{
    protected function getEloquentModel(Builder $builer, ?string $objectId): Model
    {
        if ($objectId === null) {
            throw new AuthorizationFailedException("Object Id required");
        }
        $model = $builer->find($objectId);
        return $model ?? throw new AuthorizationFailedException("Cannot retrieve data");
    }
}
