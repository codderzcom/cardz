<?php

namespace Cardz\Core\Cards\Infrastructure\Persistence\Eloquent;

use App\Models\Card as EloquentCard;
use Cardz\Core\Cards\Domain\Model\Card\Card;
use Cardz\Core\Cards\Domain\Model\Card\CardId;
use Cardz\Core\Cards\Domain\Persistence\Contracts\CardRepositoryInterface;
use Cardz\Core\Cards\Infrastructure\Exceptions\CardNotFoundException;
use Codderz\Platypus\Infrastructure\Support\PropertiesExtractorTrait;
use function json_try_decode;

class CardRepository implements CardRepositoryInterface
{
    use PropertiesExtractorTrait;

    public function persist(Card $card): void
    {
        EloquentCard::query()->updateOrCreate(
            ['id' => $card->cardId],
            $this->cardAsData($card)
        );
    }

    public function take(CardId $cardId): Card
    {
        /** @var EloquentCard $eloquentCard */
        $eloquentCard = EloquentCard::query()->find((string) $cardId);
        if ($eloquentCard === null) {
            throw new CardNotFoundException((string) $cardId);
        }
        return $this->cardFromData($eloquentCard);
    }

    private function cardAsData(Card $card): array
    {
        $properties = $this->extractProperties($card, 'issued', 'satisfied', 'completed', 'revoked', 'blocked');
        $data = [
            'id' => (string) $card->cardId,
            'plan_id' => (string) $card->planId,
            'customer_id' => (string) $card->customerId,
            'description' => (string) $card->getDescription(),
            'issued_at' => $properties['issued'],
            'satisfied_at' => $properties['satisfied'],
            'completed_at' => $properties['completed'],
            'revoked_at' => $properties['revoked'],
            'blocked_at' => $properties['blocked'],
            'achievements' => $card->getAchievements()->toArray(),
            'requirements' => $card->getRequirements()->toArray(),
        ];

        return $data;
    }

    private function cardFromData(EloquentCard $eloquentCard): Card
    {
        $achievements = is_string($eloquentCard->achievements) ? json_try_decode($eloquentCard->achievements) : $eloquentCard->achievements;
        $requirements = is_string($eloquentCard->requirements) ? json_try_decode($eloquentCard->requirements) : $eloquentCard->requirements;

        $card = Card::restore(
            $eloquentCard->id,
            $eloquentCard->plan_id,
            $eloquentCard->customer_id,
            $eloquentCard->description,
            $eloquentCard->issued_at,
            $eloquentCard->satisfied_at,
            $eloquentCard->completed_at,
            $eloquentCard->revoked_at,
            $eloquentCard->blocked_at,
            $achievements,
            $requirements,
        );
        return $card;
    }
}
