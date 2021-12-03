<?php

namespace Cardz\Core\Cards\Domain\Model\Card;

use Cardz\Core\Cards\Domain\Model\Plan\Requirement;
use Codderz\Platypus\Contracts\Domain\ValueObjectInterface;
use Codderz\Platypus\Exceptions\ParameterAssertionException;
use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

#[Immutable]
final class Achievements implements ValueObjectInterface
{
    private array $achievements;

    private function __construct(Achievement ...$achievements)
    {
        $this->achievements = $achievements;
    }

    public static function of(array ...$achievementsData): self
    {
        $achievements = [];
        foreach ($achievementsData as $achievementData) {
            if (!array_key_exists(0, $achievementData) || !array_key_exists(1, $achievementData)) {
                throw new ParameterAssertionException("Expected proper achievement data");
            }
            $achievements[] = Achievement::of($achievementData[0], $achievementData[1]);
        }
        return new self(...$achievements);
    }

    #[Pure]
    public static function from(Requirement ...$requirements): self
    {
        $achievements = [];
        foreach ($requirements as $requirement) {
            $achievements[] = Achievement::of($requirement->requirementId, $requirement->description);
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

    #[Pure]
    public function remove(Achievement $achievement): self
    {
        $achievements = [];
        foreach ($this->achievements as $presentAchievement) {
            if (!$presentAchievement->equals($achievement)) {
                $achievements[] = $presentAchievement;
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

    #[Pure]
    public function removeById(string $achievementId): self
    {
        $achievements = [];
        foreach ($this->achievements as $presentAchievement) {
            if ($presentAchievement->getId() !== $achievementId) {
                $achievements[] = $presentAchievement;
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
