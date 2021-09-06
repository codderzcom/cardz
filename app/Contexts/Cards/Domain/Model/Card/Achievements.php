<?php

namespace App\Contexts\Cards\Domain\Model\Card;

use App\Contexts\Plans\Domain\Model\Shared\ValueObject;
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
    public static function of(string ...$descriptions): self
    {
        $achievements = [];
        foreach ($descriptions as $description) {
            $achievements[] = Achievement::of($description);
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
            $data[] = $achievement->getDescription();
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
            if ($achievement->equals($presentAchievement)) {
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
