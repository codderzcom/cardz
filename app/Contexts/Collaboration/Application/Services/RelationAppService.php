<?php

namespace App\Contexts\Collaboration\Application\Services;

use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use App\Shared\Infrastructure\Support\ReportingServiceTrait;

class RelationAppService
{
    use ReportingServiceTrait;

    public function __construct(
        private RelationRepositoryInterface $relationRepository,
    ) {
    }

    public function leave(string $relationId): RelationId
    {
        $relation = $this->relationRepository->take(RelationId::of($relationId));
        $relation->leave();
        $this->relationRepository->persist($relation);
        return $relation->relationId;
    }
}
