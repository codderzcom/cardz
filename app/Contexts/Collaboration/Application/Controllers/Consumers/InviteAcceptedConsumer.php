<?php

namespace App\Contexts\Collaboration\Application\Controllers\Consumers;

use App\Contexts\Collaboration\Application\Contracts\InviteRepositoryInterface;
use App\Contexts\Collaboration\Application\IntegrationEvents\InviteAccepted;
use App\Contexts\Collaboration\Application\Services\RelationAppService;
use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationType;
use App\Contexts\Shared\Contracts\Informable;
use App\Contexts\Shared\Contracts\Reportable;

final class InviteAcceptedConsumer implements Informable
{
    public function __construct(
        private InviteRepositoryInterface $inviteRepository,
        private RelationAppService $relationAppService,
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
        $invite = $this->inviteRepository->take(InviteId::of($event->id()));
        if ($invite === null) {
            return;
        }
        $this->relationAppService->enter($invite->collaboratorId, $invite->workspaceId, RelationType::MEMBER());
    }
}
