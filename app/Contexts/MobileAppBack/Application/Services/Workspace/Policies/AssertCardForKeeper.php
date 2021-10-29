<?php

namespace App\Contexts\MobileAppBack\Application\Services\Workspace\Policies;

use App\Contexts\MobileAppBack\Application\Exceptions\AssertionException;
use App\Contexts\MobileAppBack\Domain\Model\Card\CardId;
use App\Contexts\MobileAppBack\Domain\Model\Collaboration\KeeperId;
use App\Models\Card as EloquentCard;
use App\Shared\Contracts\PolicyAssertionInterface;
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

    public function assert(): void
    {
        $card = EloquentCard::query()
            ->find($this->cardId)
            ?->plan()
            ?->workspace()
            ->where('keeper_id', '=', (string) $this->keeperId)
            ->first();
        if ($card === null) {
            throw new AssertionException("Cards {$this->cardId} is not for keeper {$this->keeperId}");
        }
    }
}
