<?php

namespace App\Contexts\Cards\Domain\Model\Card;

use App\Contexts\Cards\Domain\Model\Shared\ValueObject;
use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

#[Immutable]
final class Achievements extends ValueObject
{
    private array $achievements;

    private function __construct(Achievement ...$achievements)
    {
        $this->achievements = $achievements;
    }

    #[Pure]
    public static function of(array ...$achievementsData): self
    {
        $achievements = [];
        foreach ($achievementsData as $achievementData) {
            $achievements[] = Achievement::of($achievementData[0], $achievementData[1]);
        }
        return new self(...$achievements);
    }

    #[Pure]
    public function copy(): self
    {
        return new self(...$this->achievements);
    }

    #[Pure]
    public function toArray(): array
    {
        $data = [];
        foreach ($this->achievements as $achievement) {
            $data[] = $achievement->toArray();
        }
        return $data;
    }

    #[Pure]
    public function add(Achievement $achievement): self
    {
        $achievements = $this->achievements;
        $achievements[] = $achievement;
        return new self(...$achievements);
    }

    public function remove(Achievement $achievement): self
    {
        $achievements = $this->achievements;
        foreach ($achievements as $index => $presentAchievement) {
            if ($presentAchievement->equals($achievement)) {
                unset($achievements[$index]);
                break;
            }
        }
        return new self(...$achievements);
    }

    #[Pure]
    public function replace(Achievement $achievement): self
    {
        $achievements = $this->achievements;
        foreach ($achievements as $index => $presentAchievement) {
            if ($presentAchievement->equals($achievement)) {
                $achievements[$index] = $achievement;
            }
        }
        return new self(...$achievements);
    }

    public function removeById(string $achievementId): self
    {
        $achievements = $this->achievements;
        foreach ($achievements as $index => $presentAchievement) {
            if ($presentAchievement->getId() === $achievementId) {
                unset($achievements[$index]);
                break;
            }
        }
        return new self(...$achievements);
    }

    public function filterRemaining(self $achievements): self
    {
        $currentAchievements = $this->achievements;
        foreach ($achievements->achievements as $achievement) {
            foreach ($currentAchievements as $index => $currentAchievement) {
                if ($achievement->equals($currentAchievement)) {
                    unset($currentAchievements[$index]);
                    break;
                }
            }
        }
        return new self(...$currentAchievements);
    }

    public function isEmpty(): bool
    {
        return count($this->achievements) === 0;
    }
}
