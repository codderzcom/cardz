<?php

namespace App\Contexts\Plans\Domain\Model\Achievement;

use App\Contexts\Shared\Infrastructure\Support\ArrayAccessSupportTrait;
use ArrayAccess;
use Iterator;
use JetBrains\PhpStorm\Pure;

class AchievementCollection implements ArrayAccess, Iterator
{
    use ArrayAccessSupportTrait;

    private function __construct(Achievement ...$achievements)
    {
        $this->arrayItems = $achievements ?? [];
    }

    private function getItemType(): string
    {
        return Achievement::class;
    }

    #[Pure]
    public static function of(Achievement ...$achievements): static
    {
        return new static(...$achievements);
    }

    public function offsetGet($offset): ?Achievement
    {
        return $this->arrayItems[$offset] ?: null;
    }

    public function current(): Achievement
    {
        return current($this->arrayItems);
    }

    public function extractAchievementIdCollection(): AchievementIdCollection
    {
        $achievementIds = [];
        /** @var Achievement $achievement */
        foreach ($this->arrayItems as $achievement) {
            $achievementIds[] = $achievement->achievementId;
        }
        return AchievementIdCollection::of(...$achievementIds);
    }
}
