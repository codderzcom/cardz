<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Shared\Eloquent;

use App\Contexts\MobileAppBack\Domain\Exceptions\CardNotFoundException;
use App\Contexts\MobileAppBack\Domain\ReadModel\IssuedCard;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Shared\Contracts\IssuedCardReadStorageInterface;
use App\Models\Card as EloquentCard;
use function json_try_decode;

class IssuedCardReadStorage implements IssuedCardReadStorageInterface
{
    public function find(string $cardId): IssuedCard
    {
        /** @var EloquentCard $card */
        $card = EloquentCard::query()->find($cardId);
        if ($card === null) {
            throw new CardNotFoundException("Card: $cardId");
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

    public function forCustomerId(string $customerId, string $cardId): IssuedCard
    {
        /** @var EloquentCard $card */
        $card = EloquentCard::query()
            ->where('id', '=', $cardId)
            ->where('customerId', '=', $customerId)
            ->first();
        if ($card === null) {
            throw new CardNotFoundException("Card: $cardId. Customer: $customerId");
        }

        return $this->issuedCardFromEloquent($card);
    }

    private function issuedCardFromEloquent(EloquentCard $card): IssuedCard
    {
        $achievements = is_string($card->achievements) ? json_try_decode($card->achievements) : $card->achievements;
        $requirements = is_string($card->requirements) ? json_try_decode($card->requirements) : $card->requirements;

        return IssuedCard::make(
            $card->id,
            $card->plan_id,
            $card->customer_id,
            $card->satisfied_at !== null,
            $card->completed_at !== null,
            $card->revoked_at !== null,
            $card->blocked_at !== null,
            $achievements,
            $requirements
        );
    }

}
