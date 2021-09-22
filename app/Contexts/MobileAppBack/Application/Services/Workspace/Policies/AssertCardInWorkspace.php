<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace\Policies;

use App\Contexts\MobileAppBack\Domain\Model\Card\CardId;
use App\Contexts\MobileAppBack\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Shared\Contracts\PolicyAssertionInterface;
use App\Models\Card as EloquentCard;
use JetBrains\PhpStorm\Pure;

class AssertCardInWorkspace implements PolicyAssertionInterface
{
    private function __construct(
        private CardId $cardId,
        private WorkspaceId $workspaceId,
    ) {
    }

    #[Pure]
    public static function of(CardId $cardId, WorkspaceId $workspaceId): self
    {
        return new self($cardId, $workspaceId);
    }

    public function assert(): bool
    {
        $card = EloquentCard::query()
            ->whereHas('plan', fn($query) => $query->where('workspace_id', '=', $this->workspaceId))
            ->find((string) $this->cardId);
        return $card !== null;
    }
}
