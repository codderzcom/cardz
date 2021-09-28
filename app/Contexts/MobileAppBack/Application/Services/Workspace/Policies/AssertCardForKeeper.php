<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace\Policies;

use App\Contexts\MobileAppBack\Domain\Model\Card\CardId;
use App\Contexts\MobileAppBack\Domain\Model\Collaboration\KeeperId;
use App\Models\Card as EloquentCard;
use App\Shared\Contracts\PolicyAssertionInterface;
use App\Shared\Contracts\PolicyViolationInterface;
use App\Shared\Infrastructure\Policy\PolicyViolation;
use JetBrains\PhpStorm\Pure;

final class AssertCardForKeeper implements PolicyAssertionInterface
{
    private function __construct(
        private CardId $cardId,
        private KeeperId $keeperId,
    ) {
    }

    #[Pure]
    public static function of(CardId $cardId, KeeperId $keeperId): self
    {
        return new self($cardId, $keeperId);
    }

    public function assert(): bool
    {
        $card = EloquentCard::query()
            ->find($this->cardId)
            ?->plan()
            ?->workspace()
            ->where('keeper_id', '=', (string) $this->keeperId)
            ->first();
        return $card !== null;
    }

    public function violation(): PolicyViolationInterface
    {
        return PolicyViolation::of("Card {$this->cardId} is not for keeper {$this->keeperId}");
    }
}
