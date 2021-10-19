<?php

namespace App\Contexts\Collaboration\Infrastructure\Persistence\Eloquent;

use App\Contexts\Collaboration\Domain\Model\Invite\Invite;
use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
use App\Contexts\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;
use App\Contexts\Collaboration\Infrastructure\Exceptions\InviteNotFoundException;
use App\Models\Invite as EloquentInvite;
use ReflectionClass;

class InviteRepository implements InviteRepositoryInterface
{
    public function persist(Invite $invite): void
    {
        EloquentInvite::query()->updateOrCreate(
            ['id' => $invite->inviteId],
            $this->inviteAsData($invite)
        );
    }

    public function take(InviteId $inviteId = null): Invite
    {
        /** @var EloquentInvite $eloquentInvite */
        $eloquentInvite = EloquentInvite::query()->find((string) $inviteId);
        return $eloquentInvite ? $this->inviteFromData($eloquentInvite) : throw new InviteNotFoundException((string) $inviteId);
    }

    public function remove(InviteId $inviteId): void
    {
        EloquentInvite::query()->where('id', '=', $inviteId)->delete();
    }

    private function inviteAsData(Invite $invite): array
    {
        $reflection = new ReflectionClass($invite);
        $properties = [
            'collaboratorId' => null,
            'proposed' => null,
            'accepted' => null,
        ];

        foreach ($properties as $key => $property) {
            $property = $reflection->getProperty($key);
            $property->setAccessible(true);
            $properties[$key] = $property->getValue($invite);
        }

        $data = [
            'id' => (string) $invite->inviteId,
            'inviter_id' => (string) $invite->inviterId,
            'workspace_id' => (string) $invite->workspaceId,
            'member_id' => $properties['collaboratorId'] !== null ? (string) $properties['collaboratorId'] : null,
            'proposed_at' => $properties['proposed'],
            'accepted_at' => $properties['accepted'],
        ];

        return $data;
    }

    private function inviteFromData(EloquentInvite $eloquentInvite): Invite
    {
        $invite = Invite::restore(
            $eloquentInvite->id,
            $eloquentInvite->inviter_id,
            $eloquentInvite->workspace_id,
            $eloquentInvite->collaborator_id,
            $eloquentInvite->proposed_at,
            $eloquentInvite->accepted_at,
        );
        return $invite;
    }

}
