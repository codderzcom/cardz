<?php

namespace App\Contexts\Plans\Domain\Model\Achievement;

use App\Contexts\Shared\Infrastructure\Support\ArrayAccessSupportTrait;
use ArrayAccess;
use Iterator;
use JetBrains\PhpStorm\Pure;

class AchievementIdCollection implements ArrayAccess, Iterator
{
    use ArrayAccessSupportTrait;

    private function __construct(AchievementId ...$achievementIds)
    {
        $this->arrayItems = $achievementIds ?? [];
    }

    private function getItemType(): string
    {
        return AchievementId::class;
    }

    public static function ofIds(string ...$ids)
    {
        $achievementIds = new static();
        foreach ($ids as $id) {
            $achievementIds[] = AchievementId::of($id);
        }
        return $achievementIds;
    }

    #[Pure]
    public static function of(AchievementId ...$achievementIds): static
    {
        return new static(...$achievementIds);
    }

    public function offsetGet($offset): ?AchievementId
    {
        return $this->arrayItems[$offset] ?: null;
    }

    public function current(): AchievementId
    {
        return current($this->arrayItems);
    }

    public function toIds(): array
    {
        $ids = [];
        foreach ($this->arrayItems as $achievementId) {
            $ids[] = (string) $achievementId;
        }
        return $ids;
    }
}
