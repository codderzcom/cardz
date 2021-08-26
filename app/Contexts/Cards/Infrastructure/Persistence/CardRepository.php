<?php

namespace App\Contexts\Cards\Infrastructure\Persistence;

use App\Contexts\Cards\Application\Contracts\CardRepositoryInterface;
use App\Contexts\Cards\Domain\Model\Card\Achievement;
use App\Contexts\Cards\Domain\Model\Card\AchievementId;
use App\Contexts\Cards\Domain\Model\Card\Card;
use App\Contexts\Cards\Domain\Model\Card\CardId;
use App\Models\Card as EloquentCard;
use JetBrains\PhpStorm\Pure;
use ReflectionClass;
use function json_try_decode;
use function json_try_encode;

class CardRepository implements CardRepositoryInterface
{
    public function persist(?Card $card = null): void
    {
        if ($card === null) {
            return;
        }

        EloquentCard::updateOrCreate(['id' => $card->cardId], $this->cardAsData($card));
    }

    public function take(?CardId $cardId = null): ?Card
    {
        if ($cardId === null) {
            return null;
        }
        /** @var EloquentCard $eloquentCard */
        $eloquentCard = EloquentCard::query()->where([
            'id' => (string) $cardId,
            'blocked_at' => null,
        ])?->first();
        if ($eloquentCard === null) {
            return null;
        }
        return $this->cardFromData($eloquentCard);
    }

    private function cardAsData(Card $card): array
    {
        $reflection = new ReflectionClass($card);
        $properties = [
            'issued' => null,
            'completed' => null,
            'revoked' => null,
            'blocked' => null,
        ];

        foreach ($properties as $key => $property) {
            $property = $reflection->getProperty($key);
            $property->setAccessible(true);
            $properties[$key] = $property->getValue($card);
        }

        $data = [
            'id' => (string) $card->cardId,
            'bonus_program_id' => (string) $card->bonusProgramId,
            'customer_id' => (string) $card->customerId,
            'description' => $card->getDescription(),
            'issued_at' => $properties['issued'],
            'completed_at' => $properties['completed'],
            'revoked_at' => $properties['revoked'],
            'blocked_at' => $properties['blocked'],
            'achievements' => json_try_encode($this->achievementsAsData($card->getAchievements())),
        ];

        return $data;
    }

    /**
     * @param array<Achievement> $achievements
     */
    #[Pure] private function achievementsAsData(array $achievements): array
    {
        $achievementsData = [];
        /** @var Achievement $achievement */
        foreach ($achievements as $achievement) {
            $achievementsData[] = $achievement->toArray();
        }
        return $achievementsData;
    }

    private function cardFromData(EloquentCard $eloquentCard): Card
    {
        $reflection = new ReflectionClass(Card::class);
        $creator = $reflection->getMethod('from');
        $creator?->setAccessible(true);
        /** @var ?Card $card */
        $card = $reflection->newInstanceWithoutConstructor();

        $achievements = $eloquentCard->achievements ? json_try_decode($eloquentCard->achievements, true) : [];

        $creator?->invoke($card,
            $eloquentCard->id,
            $eloquentCard->bonus_program_id,
            $eloquentCard->customer_id,
            $eloquentCard->description,
            $eloquentCard->issued_at,
            $eloquentCard->completed_at,
            $eloquentCard->revoked_at,
            $eloquentCard->blocked_at,
            $this->achievementsFromData($achievements)
        );
        return $card;
    }

    /**
     * @return array<Achievement>|null
     */
    private function achievementsFromData(?array $achievementsData = null): ?array
    {
        if ($achievementsData === null) {
            return [];
        }
        $achievements = [];
        $reflection = new ReflectionClass(Achievement::class);
        $constructor = $reflection->getConstructor();
        $constructor?->setAccessible(true);
        foreach ($achievementsData as $achievementData) {
            $achievement = $reflection->newInstanceWithoutConstructor();
            $achievementId = new AchievementId($achievementData['id']);
            $constructor?->invoke($achievement, $achievementId, $achievementData['description']);
            $achievements[(string) $achievementId] = $achievement;
        }
        return $achievements;
    }
}
