<?php

namespace App\Contexts\Cards\Domain\ReadModel;

use App\Contexts\Cards\Domain\Model\Card\Achievement;
use App\Contexts\Shared\Infrastructure\Support\ArrayAccessSupportTrait;
use ArrayAccess;
use Iterator;
use JetBrains\PhpStorm\Pure;

class PlanRequirementsCollection implements ArrayAccess, Iterator
{
    use ArrayAccessSupportTrait;

    private function __construct(PlanRequirement ...$planRequirements)
    {
        $this->arrayItems = $planRequirements ?? [];
    }

    #[Pure]
    public static function of(PlanRequirement ...$planRequirements): static
    {
        return new static(...$planRequirements);
    }

    public function offsetGet($offset): ?PlanRequirement
    {
        return $this->arrayItems[$offset] ?: null;
    }

    public function current(): PlanRequirement
    {
        return current($this->arrayItems);
    }

    public function toAchievements(): array
    {
        $achievements = [];
        foreach ($this->arrayItems as $requirement)
        {
            $achievements[] = Achievement::of($requirement->getRequirementId(), $requirement->getDescription());
        }
        return $achievements;
    }

    private function getItemType(): string
    {
        return PlanRequirement::class;
    }
}
