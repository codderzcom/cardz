<?php

namespace App\Contexts\Collaboration\Application\Controllers\Consumers;

use App\Contexts\Collaboration\Application\Contracts\AcceptedInviteReadStorageInterface;
use App\Contexts\Collaboration\Application\Contracts\EnteredRelationReadStorageInterface;
use App\Contexts\Collaboration\Application\Contracts\InviteRepositoryInterface;
use App\Contexts\Collaboration\Application\IntegrationEvents\RelationEntered;
use App\Contexts\Shared\Contracts\Informable;
use App\Contexts\Shared\Contracts\Reportable;

final class RelationEnteredConsumer implements Informable
{
    public function __construct(
        private InviteRepositoryInterface $inviteRepository,
        private AcceptedInviteReadStorageInterface $acceptedInviteReadStorage,
        private EnteredRelationReadStorageInterface $enteredRelationReadStorage,
    ) {
    }

    public function accepts(Reportable $reportable): bool
    {
        return $reportable instanceof RelationEntered;
    }

    public function inform(Reportable $reportable): void
    {
        /** @var RelationEntered $event */
        $event = $reportable;
        $relation = $this->enteredRelationReadStorage->take($event->id());
        if ($relation === null || !$relation->isMemberRelation()) {
            return;
        }
        $invite = $this->acceptedInviteReadStorage->find($relation->memberId, $relation->workspaceId);
        if ($invite === null) {
            return;
        }

        // ToDo: насколько это правильно?
        $this->inviteRepository->remove($invite->inviteId);
    }
}
