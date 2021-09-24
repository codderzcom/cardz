<?php

namespace App\Contexts\Collaboration\Application\Services;

use App\Contexts\Collaboration\Application\Contracts\InviteRepositoryInterface;
use App\Contexts\Collaboration\Application\IntegrationEvents\InviteAccepted;
use App\Contexts\Collaboration\Application\IntegrationEvents\InviteProposed;
use App\Contexts\Collaboration\Domain\Model\Collaborator\CollaboratorId;
use App\Contexts\Collaboration\Domain\Model\Invite\Invite;
use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Shared\Contracts\ReportingBusInterface;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;
use App\Contexts\Shared\Infrastructure\Support\ReportingServiceTrait;

class InviteAppService
{
    use ReportingServiceTrait;

    public function __construct(
        private InviteRepositoryInterface $inviteRepository,
        private ReportingBusInterface $reportingBus,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function propose(string $collaboratorId, string $workspaceId): ServiceResultInterface
    {
        $invite = Invite::make(
            InviteId::make(),
            CollaboratorId::of($collaboratorId),
            WorkspaceId::of($workspaceId),
        );

        $invite->propose();
        $this->inviteRepository->persist($invite);

        $result = $this->serviceResultFactory->ok($invite->inviteId, new InviteProposed($invite->inviteId));
        return $this->reportResult($result, $this->reportingBus);
    }

    public function accept(string $inviteId): ServiceResultInterface
    {
        $invite = $this->inviteRepository->take(InviteId::of($inviteId));
        if ($invite === null) {
            return $this->serviceResultFactory->notFound("Invite $inviteId not found");
        }
        $invite->accept();
        $this->inviteRepository->remove($invite);

        $result = $this->serviceResultFactory->ok($invite->inviteId, new InviteAccepted($invite->inviteId));
        return $this->reportResult($result, $this->reportingBus);
    }

    public function reject(string $inviteId): ServiceResultInterface
    {
        $invite = $this->inviteRepository->take(InviteId::of($inviteId));
        if ($invite === null) {
            return $this->serviceResultFactory->notFound("Invite $inviteId not found");
        }
        $invite->reject();
        $this->inviteRepository->remove($invite->inviteId);

        $result = $this->serviceResultFactory->ok($invite->inviteId, new InviteAccepted($invite->inviteId));
        return $this->reportResult($result, $this->reportingBus);
    }

    public function discard(string $inviteId): ServiceResultInterface
    {
        $invite = $this->inviteRepository->take(InviteId::of($inviteId));
        if ($invite === null) {
            return $this->serviceResultFactory->notFound("Invite $inviteId not found");
        }
        $invite->discard();
        $this->inviteRepository->remove($invite->inviteId);

        $result = $this->serviceResultFactory->ok($invite->inviteId, new InviteAccepted($invite->inviteId));
        return $this->reportResult($result, $this->reportingBus);
    }
}
