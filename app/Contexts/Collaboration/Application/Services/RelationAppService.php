<?php

namespace App\Contexts\Collaboration\Application\Services;

use App\Contexts\Collaboration\Application\Contracts\RelationRepositoryInterface;
use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Relation\Relation;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationType;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Shared\Contracts\ReportingBusInterface;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;
use App\Contexts\Shared\Infrastructure\Support\ReportingServiceTrait;

class RelationAppService
{
    use ReportingServiceTrait;

    public function __construct(
        private RelationRepositoryInterface $relationRepository,
        private ReportingBusInterface $reportingBus,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function enter(string $collaboratorId, string $workspaceId, string $relationType): ServiceResultInterface
    {
        $relation = Relation::make(
            RelationId::make(),
            CollaboratorId::of($collaboratorId),
            WorkspaceId::of($workspaceId),
        );
        $relation->enter(RelationType::of($relationType));

        $this->relationRepository->persist($relation);

        return $this->serviceResultFactory->ok($relation->relationId);
    }

    public function leave(string $relationId): ServiceResultInterface
    {
        $relation = $this->relationRepository->take(RelationId::of($relationId));
        if ($relation === null) {
            return $this->serviceResultFactory->notFound("Relation $relationId not found");
        }
        $relation->leave();
        $this->relationRepository->persist($relation);
        return $this->serviceResultFactory->ok($relation->relationId);
    }
}
