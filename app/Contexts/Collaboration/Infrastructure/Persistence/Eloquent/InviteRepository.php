<?php

namespace App\Contexts\Collaboration\Infrastructure\Persistence\Eloquent;

use App\Contexts\Collaboration\Domain\Model\Invite\Invite;
use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;
use App\Contexts\Collaboration\Infrastructure\Exceptions\InviteNotFoundException;
use App\Models\Invite as EloquentInvite;
use App\Shared\Infrastructure\Support\PropertiesExtractorTrait;

class InviteRepository implements InviteRepositoryInterface
{
    use PropertiesExtractorTrait;

    public function persist(Invite $invite): void
    {
        $inviteId = (string) $invite->inviteId;
        if ($invite->isAccepted() || $invite->isDiscarded()) {
            EloquentInvite::query()->where('id', '=', $inviteId)->delete();
            return;
        }

        EloquentInvite::query()->updateOrCreate(
            ['id' => $inviteId],
            $this->inviteAsData($invite)
        );
    }

    public function take(InviteId $inviteId = null): Invite
    {
        /** @var EloquentInvite $eloquentInvite */
        $eloquentInvite = EloquentInvite::query()->find((string) $inviteId);
        return $eloquentInvite ? $this->inviteFromData($eloquentInvite) : throw new InviteNotFoundException((string) $inviteId);
    }

    private function inviteAsData(Invite $invite): array
    {
        $data = [
            'id' => (string) $invite->inviteId,
            'inviter_id' => (string) $invite->inviterId,
            'workspace_id' => (string) $invite->workspaceId,
            'proposed_at' => $this->extractProperty($invite, 'proposed'),
        ];

        return $data;
    }

    private function inviteFromData(EloquentInvite $eloquentInvite): Invite
    {
        $invite = Invite::restore(
            $eloquentInvite->id,
            $eloquentInvite->inviter_id,
            $eloquentInvite->workspace_id,
            $eloquentInvite->accepted_at,
        );
        return $invite;
    }

}
