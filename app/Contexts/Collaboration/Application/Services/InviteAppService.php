<?php

namespace App\Contexts\Collaboration\Application\Services;

use App\Contexts\Collaboration\Application\Commands\Invite\AcceptInviteCommandInterface;
use App\Contexts\Collaboration\Domain\Model\Invite\Invite;
use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Contexts\Collaboration\Infrastructure\Messaging\DomainEventBusInterface;
use App\Contexts\Collaboration\Infrastructure\Persistence\Contracts\InviteRepositoryInterface;
use App\Contexts\Collaboration\Infrastructure\Persistence\Contracts\KeeperRepositoryInterface;
use App\Contexts\Collaboration\Integration\Events\InviteAccepted;
use App\Shared\Contracts\ReportingBusInterface;
use App\Shared\Contracts\ServiceResultFactoryInterface;
use App\Shared\Contracts\ServiceResultInterface;
use App\Shared\Infrastructure\Support\ReportingServiceTrait;

class InviteAppService
{
    use ReportingServiceTrait;

    public function __construct(
        private KeeperRepositoryInterface $keeperRepository,
        private InviteRepositoryInterface $inviteRepository,
        private ReportingBusInterface $reportingBus,
        private DomainEventBusInterface $domainEventBus,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function accept(AcceptInviteCommandInterface $command): InviteId
    {
        $invite = $this->inviteRepository->take($command->getInviteId());
        $invite->accept();
        return $this->release($invite);
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

    private function release(Invite $invite): InviteId
    {
        $this->inviteRepository->persist($invite);
        $this->domainEventBus->publish(...$invite->releaseEvents());
        return $invite->inviteId;
    }
}
