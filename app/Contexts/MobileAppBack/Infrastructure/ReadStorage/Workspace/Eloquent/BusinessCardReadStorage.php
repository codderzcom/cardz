<?php

namespace App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Eloquent;

use App\Contexts\MobileAppBack\Domain\ReadModel\Workspace\BusinessCard;
use App\Contexts\MobileAppBack\Domain\ReadModel\Workspace\BusinessWorkspace;
use App\Contexts\MobileAppBack\Infrastructure\Exceptions\BusinessCardNotFoundException;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Workspace\Contracts\BusinessCardReadStorageInterface;
use App\Models\Card as EloquentCard;

class BusinessCardReadStorage implements BusinessCardReadStorageInterface
{
    public function find(string $cardId): BusinessCard
    {
        /** @var EloquentCard $card */
        $card = EloquentCard::query()->find($cardId);
        if ($card === null) {
            throw new BusinessCardNotFoundException("Card Id: $cardId");
        }
        return $this->cardFromEloquent($card);
    }

    /**
     * @return BusinessWorkspace[]
     */
    public function allForPlan(string $planId): array
    {
        $cards = EloquentCard::query()
            ->where('plan_id', '=', $planId)
            ->get();
        $planCards = [];
        foreach ($cards as $card) {
            $planCards[] = $this->cardFromEloquent($card);
        }

        return $planCards;
    }

    private function cardFromEloquent(EloquentCard $card): BusinessCard
    {
        $achievements = is_string($card->achievements) ? json_try_decode($card->achievements, true) : $card->achievements;
        $requirements = is_string($card->requirements) ? json_try_decode($card->requirements, true) : $card->requirements;

        return BusinessCard::make(
            $card->id,
            $card->plan_id,
            $card->customer_id,
            $card->issued_at,
            $card->satisfied_at,
            $card->completed_at,
            $card->revoked_at,
            $card->blocked_at,
            $achievements,
            $requirements
        );
    }
}
