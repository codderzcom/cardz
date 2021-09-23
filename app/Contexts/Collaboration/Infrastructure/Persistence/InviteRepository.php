<?php

namespace App\Contexts\Collaboration\Infrastructure\Persistence;

use App\Contexts\Collaboration\Application\Contracts\InviteRepositoryInterface;
use App\Contexts\Collaboration\Domain\Model\Invite\Invite;
use App\Contexts\Collaboration\Domain\Model\Invite\InviteId;
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

    public function take(InviteId $inviteId = null): ?Invite
    {
        /** @var EloquentInvite $eloquentInvite */
        $eloquentInvite = EloquentInvite::query()->find((string) $inviteId);
        if ($eloquentInvite === null) {
            return null;
        }
        return $this->inviteFromData($eloquentInvite);
    }

    public function remove(InviteId $inviteId): void
    {
        EloquentInvite::query()->where('id', '=', $inviteId)->delete();
    }

    private function inviteAsData(Invite $invite): array
    {
        $reflection = new ReflectionClass($invite);
        $properties = [
            'proposed' => null,
        ];

        foreach ($properties as $key => $property) {
            $property = $reflection->getProperty($key);
            $property->setAccessible(true);
            $properties[$key] = $property->getValue($invite);
        }

        $data = [
            'id' => (string) $invite->inviteId,
            'collaborator_id' => (string) $invite->collaboratorId,
            'workspace_id' => (string) $invite->workspaceId,
            'proposed_at' => $properties['proposed'],
        ];

        return $data;
    }

    private function inviteFromData(EloquentInvite $eloquentInvite): Invite
    {
        $reflection = new ReflectionClass(Invite::class);
        $creator = $reflection->getMethod('from');
        $creator?->setAccessible(true);
        /** @var Invite $invite */
        $invite = $reflection->newInstanceWithoutConstructor();

        $creator?->invoke($invite,
            $eloquentInvite->id,
            $eloquentInvite->collaborator_id,
            $eloquentInvite->workspace_id,
            $eloquentInvite->proposed_at,
        );
        return $invite;
    }

}
