<?php

namespace Cardz\Support\Collaboration\Infrastructure\Persistence\Eloquent;

use App\Models\Invite as EloquentInvite;
use Carbon\Carbon;
use Cardz\Support\Collaboration\Domain\Model\Invite\Invite;
use Cardz\Support\Collaboration\Domain\Model\Invite\InviteId;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;
use Cardz\Support\Collaboration\Infrastructure\Exceptions\InviteNotFoundException;
use Codderz\Platypus\Infrastructure\Support\PropertiesExtractorTrait;
use JetBrains\PhpStorm\ArrayShape;

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

    #[ArrayShape(['id' => "string", 'inviter_id' => "string", 'workspace_id' => "string", 'proposed_at' => Carbon::class | null])]
    private function inviteAsData(Invite $invite): array
    {
        return [
            'id' => (string) $invite->inviteId,
            'inviter_id' => (string) $invite->inviterId,
            'workspace_id' => (string) $invite->workspaceId,
            'proposed_at' => $this->extractProperty($invite, 'proposed'),
        ];
    }

    private function inviteFromData(EloquentInvite $eloquentInvite): Invite
    {
        return Invite::restore(
            $eloquentInvite->id,
            $eloquentInvite->inviter_id,
            $eloquentInvite->workspace_id,
            $eloquentInvite->accepted_at,
        );
    }

}
