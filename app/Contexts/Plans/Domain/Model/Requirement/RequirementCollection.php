<?php

namespace App\Contexts\Plans\Domain\Model\Requirement;

use App\Contexts\Shared\Infrastructure\Support\ArrayAccessSupportTrait;
use ArrayAccess;
use Iterator;
use JetBrains\PhpStorm\Pure;

class RequirementCollection implements ArrayAccess, Iterator
{
    use ArrayAccessSupportTrait;

    private function __construct(Requirement ...$requirements)
    {
        $this->arrayItems = $requirements ?? [];
    }

    #[Pure]
    public static function of(Requirement ...$requirements): static
    {
        return new static(...$requirements);
    }

    public function offsetGet($offset): ?Requirement
    {
        return $this->arrayItems[$offset] ?: null;
    }

    public function current(): Requirement
    {
        return current($this->arrayItems);
    }

    public function extractRequirementIdCollection(): RequirementIdCollection
    {
        $requirementIds = [];
        /** @var Requirement $requirement */
        foreach ($this->arrayItems as $requirement) {
            $requirementIds[] = $requirement->requirementId;
        }
        return RequirementIdCollection::of(...$requirementIds);
    }

    private function getItemType(): string
    {
        return Requirement::class;
    }
}
