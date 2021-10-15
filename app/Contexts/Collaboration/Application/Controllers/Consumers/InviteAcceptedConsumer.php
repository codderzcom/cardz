<?php

namespace App\Contexts\Collaboration\Application\Controllers\Consumers;

use App\Contexts\Collaboration\Application\Services\MemberAppService;
use App\Contexts\Collaboration\Infrastructure\ReadStorage\Contracts\AcceptedInviteReadStorageInterface;
use App\Contexts\Collaboration\Integration\Events\InviteAccepted;
use App\Shared\Contracts\Informable;
use App\Shared\Contracts\Reportable;

final class InviteAcceptedConsumer implements Informable
{
    public function __construct(
        private MemberAppService $memberAppService,
        private AcceptedInviteReadStorageInterface $acceptedInviteReadStorage,
    ) {
    }

    public function accepts(Reportable $reportable): bool
    {
        return $reportable instanceof InviteAccepted;
    }

    public function inform(Reportable $reportable): void
    {
        /** @var InviteAccepted $event */
        $event = $reportable;
        $acceptedInvite = $this->acceptedInviteReadStorage->take($event->id());
        if ($acceptedInvite === null) {
            return;
        }
        $this->memberAppService->acceptInvite($acceptedInvite->memberId, $acceptedInvite->workspaceId);
    }
}
