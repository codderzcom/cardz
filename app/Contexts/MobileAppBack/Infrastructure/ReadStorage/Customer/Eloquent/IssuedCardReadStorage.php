<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Customer\Eloquent;

use App\Contexts\MobileAppBack\Domain\ReadModel\IssuedCard;
use App\Contexts\MobileAppBack\Infrastructure\Exceptions\IssuedCardNotFoundException;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Customer\Contracts\IssuedCardReadStorageInterface;
use App\Models\Card as EloquentCard;
use function json_try_decode;

class IssuedCardReadStorage implements IssuedCardReadStorageInterface
{
    public function allForCustomer(string $customerId): array
    {
        /** @var EloquentCard $card */
        $cards = EloquentCard::query()
            ->where('customer_id', '=', $customerId)
            ->whereNull('revoked_id')
            ->whereNull('blocked_id')
            ->get();
        $issuedCards = [];
        foreach ($cards as $card) {
            $issuedCards[] = $this->issuedCardFromEloquent($card);
        }

        return $issuedCards;
    }

    public function forCustomer(string $customerId, string $cardId): IssuedCard
    {
        /** @var EloquentCard $card */
        $card = EloquentCard::query()
            ->where('id', '=', $cardId)
            ->where('customerId', '=', $customerId)
            ->whereNull('revoked_id')
            ->whereNull('blocked_id')
            ->first();
        if ($card === null) {
            throw new IssuedCardNotFoundException("Card: $cardId. Customer: $customerId");
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
            $achievements,
            $requirements
        );
    }

}
