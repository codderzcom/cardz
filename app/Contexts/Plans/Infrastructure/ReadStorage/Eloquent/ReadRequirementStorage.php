<?php

namespace App\Contexts\Plans\Infrastructure\ReadStorage\Eloquent;

use App\Contexts\Plans\Domain\ReadModel\ReadRequirement;
use App\Contexts\Plans\Infrastructure\ReadStorage\Contracts\ReadRequirementStorageInterface;
use App\Models\Requirement as EloquentRequirement;

class ReadRequirementStorage implements ReadRequirementStorageInterface
{
    public function take(?string $requirementId): ?ReadRequirement
    {
        if ($requirementId === null) {
            return null;
        }
        /** @var EloquentRequirement $eloquentRequirement */
        $eloquentRequirement = EloquentRequirement::query()
            ->where('id', '=', $requirementId)
            ->whereNull('removed_at')
            ->first();
        if ($eloquentRequirement === null) {
            return null;
        }
        return new ReadRequirement(
            $eloquentRequirement->id,
            $eloquentRequirement->plan_id,
            $eloquentRequirement->description,
        );
    }
}
