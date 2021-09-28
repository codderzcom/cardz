<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace\Policies;

use App\Contexts\MobileAppBack\Domain\Model\Card\CardId;
use App\Contexts\MobileAppBack\Domain\Model\Workspace\WorkspaceId;
use App\Models\Card as EloquentCard;
use App\Shared\Contracts\PolicyAssertionInterface;
use App\Shared\Contracts\PolicyViolationInterface;
use App\Shared\Infrastructure\Policy\PolicyViolation;
use JetBrains\PhpStorm\Pure;

final class AssertCardInWorkspace implements PolicyAssertionInterface
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

    public function violation(): PolicyViolationInterface
    {
        return PolicyViolation::of("Card {$this->cardId} is not in workspace {$this->workspaceId}");
    }

}
