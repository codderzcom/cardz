<?php

namespace App\Contexts\Collaboration\Application\Services;

use App\Contexts\Collaboration\Application\Contracts\InviteRepositoryInterface;
use App\Contexts\Collaboration\Application\Contracts\KeeperRepositoryInterface;
use App\Contexts\Collaboration\Application\Contracts\RelationRepositoryInterface;
use App\Contexts\Collaboration\Application\IntegrationEvents\InviteProposed;
use App\Contexts\Collaboration\Application\IntegrationEvents\RelationEntered;
use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationType;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Shared\Contracts\ReportingBusInterface;
use App\Shared\Contracts\ServiceResultFactoryInterface;
use App\Shared\Contracts\ServiceResultInterface;
use App\Shared\Infrastructure\Support\ReportingServiceTrait;

class KeeperAppService
{
    use ReportingServiceTrait;

    public function __construct(
        private KeeperRepositoryInterface $keeperRepository,
        private RelationRepositoryInterface $relationRepository,
        private InviteRepositoryInterface $inviteRepository,
        private ReportingBusInterface $reportingBus,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function bindWorkspace(string $keeperId, string $workspaceId): ServiceResultInterface
    {
        $keeper = $this->keeperRepository->take(CollaboratorId::of($keeperId), WorkspaceId::of($workspaceId));
        if ($keeper === null) {
            return $this->serviceResultFactory->violation("Collaborator $keeperId does not keep workspace $workspaceId");
        }

        $relation = $keeper->keepWorkspace();
        $relation->enter(RelationType::KEEPER());
        $this->relationRepository->persist($relation);

        $result = $this->serviceResultFactory->ok($relation->relationId, new RelationEntered($relation->relationId));
        return $this->reportResult($result, $this->reportingBus);
    }

    public function invite(string $keeperId, string $memberId, string $workspaceId): ServiceResultInterface
    {
        $keeper = $this->keeperRepository->take(CollaboratorId::of($keeperId), WorkspaceId::of($workspaceId));
        if ($keeper === null) {
            return $this->serviceResultFactory->violation("Collaborator $keeperId cannot make invitations to the workspace $workspaceId");
        }

        $invite = $keeper->invite(CollaboratorId::of($memberId));
        $invite->propose();
        $this->inviteRepository->persist($invite);

        $result = $this->serviceResultFactory->ok($invite->inviteId, new InviteProposed($invite->inviteId));
        return $this->reportResult($result, $this->reportingBus);
    }
}
