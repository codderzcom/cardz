<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace\Policies;

use App\Contexts\MobileAppBack\Domain\Model\Card\CardId;
use App\Contexts\MobileAppBack\Domain\Model\Workspace\KeeperId;
use App\Contexts\Shared\Contracts\PolicyAssertionInterface;
use App\Models\Card as EloquentCard;
use JetBrains\PhpStorm\Pure;

class AssertCardForKeeper implements PolicyAssertionInterface
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
}
