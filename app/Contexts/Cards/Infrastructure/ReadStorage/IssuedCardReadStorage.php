<?php

namespace App\Contexts\Cards\Infrastructure\ReadStorage;

use App\Contexts\Cards\Application\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\Cards\Domain\Model\Card\CardId;
use App\Contexts\Cards\Domain\ReadModel\IssuedCard;
use App\Contexts\Cards\Domain\ReadModel\StatefulRequirement;
use App\Models\Card as EloquentCard;
use App\Models\Requirement as EloquentRequirement;

class IssuedCardReadStorage implements IssuedCardReadStorageInterface
{
    public function find(CardId $cardId): ?IssuedCard
    {
        /** @var EloquentCard $card */
        $card = EloquentCard::query()->find((string) $cardId);
        if ($card === null) {
            return null;
        }

        $requirements =  $this->getCardRequirements($card);
        $statefulRequirements = $this->getStatefulRequirements($card, ...$requirements);

        return IssuedCard::make(
            $card->id,
            $card->plan_id,
            $card->customer_id,
            $card->satisfied !== null,
            $card->completed !== null,
            $card->revoked !== null,
            $card->blocked !== null,
            ...$statefulRequirements
        );
    }

    private function getStatefulRequirements(EloquentCard $card, EloquentRequirement ...$requirements): array
    {
        $statefulRequirements = [];
        $achievements = is_string($card->achievements) ? json_try_decode($card->achievements) : $card->achievements;
        foreach ($requirements as $requirement) {
            $achieved = false;
            $id = $requirement->id;
            $description = $requirement->description;
            foreach ($achievements as $achievement)
            {
                if ($achievement->requirement_id === $id) {
                    $achieved = true;
                    $description = $achievement->description;
                    break;
                }
            }
            $statefulRequirements[] = StatefulRequirement::make($id, $description, $achieved);
        }
        return $statefulRequirements;
    }

    private function getCardRequirements(EloquentCard $card): array
    {
        $requirements = EloquentRequirement::query()
            ->where('plan_id', '=', $card->planId)
            ->get();

        return $requirements;
    }

}
