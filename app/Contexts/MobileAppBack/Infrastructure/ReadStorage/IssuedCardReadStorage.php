<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ReadStorage;

use App\Contexts\MobileAppBack\Application\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\MobileAppBack\Domain\ReadModel\IssuedCard;
use App\Models\Card as EloquentCard;

class IssuedCardReadStorage implements IssuedCardReadStorageInterface
{
    public function find(string $cardId): ?IssuedCard
    {
        /** @var EloquentCard $card */
        $card = EloquentCard::query()->find($cardId);
        if ($card === null) {
            return null;
        }

        return $this->issuedCardFromEloquent($card);
    }

    public function allForPlanId(string $planId): array
    {
        /** @var EloquentCard $card */
        $cards = EloquentCard::query()->where('plan_id', '=', $planId)->get();
        $issuedCards = [];
        foreach ($cards as $card) {
            $issuedCards[] = $this->issuedCardFromEloquent($card);
        }

        return $issuedCards;
    }

    public function allForCustomerId(string $customerId): array
    {
        /** @var EloquentCard $card */
        $cards = EloquentCard::query()->where('customer_id', '=', $customerId)->get();
        $issuedCards = [];
        foreach ($cards as $card) {
            $issuedCards[] = $this->issuedCardFromEloquent($card);
        }

        return $issuedCards;
    }

    private function issuedCardFromEloquent(EloquentCard $card): IssuedCard
    {
        $achievements = is_string($card->achievements) ? json_try_decode($card->achievements) : $card->achievements;
        $requirements = is_string($card->requirements) ? json_try_decode($card->requirements) : $card->requirements;

        return IssuedCard::make(
            $card->id,
            $card->plan_id,
            $card->customer_id,
            $card->satisfied !== null,
            $card->completed !== null,
            $card->revoked !== null,
            $card->blocked !== null,
            $achievements,
            $requirements
        );
    }
}
