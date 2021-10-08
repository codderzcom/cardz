<?php

namespace App\Contexts\Cards\Infrastructure\ReadStorage\Eloquent;

use App\Contexts\Cards\Domain\ReadModel\IssuedCard;
use App\Contexts\Cards\Infrastructure\ReadStorage\Contracts\IssuedCardReadStorageInterface;
use App\Models\Card as EloquentCard;
use function json_try_decode;

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
