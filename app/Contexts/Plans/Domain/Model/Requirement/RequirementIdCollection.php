<?php

namespace App\Contexts\Plans\Domain\Model\Requirement;

use App\Contexts\Shared\Infrastructure\Support\ArrayAccessSupportTrait;
use ArrayAccess;
use Iterator;
use JetBrains\PhpStorm\Pure;

class RequirementIdCollection implements ArrayAccess, Iterator
{
    use ArrayAccessSupportTrait;

    private function __construct(RequirementId ...$requirementIds)
    {
        $this->arrayItems = $requirementIds ?? [];
    }

    public static function ofIds(string ...$ids)
    {
        $requirementIds = new static();
        foreach ($ids as $id) {
            $requirementIds[] = RequirementId::of($id);
        }
        return $requirementIds;
    }

    #[Pure]
    public static function of(RequirementId ...$requirementIds): static
    {
        return new static(...$requirementIds);
    }

    public function offsetGet($offset): ?RequirementId
    {
        return $this->arrayItems[$offset] ?: null;
    }

    public function current(): RequirementId
    {
        return current($this->arrayItems);
    }

    public function toIds(): array
    {
        $ids = [];
        foreach ($this->arrayItems as $requirementId) {
            $ids[] = (string) $requirementId;
        }
        return $ids;
    }

    private function getItemType(): string
    {
        return RequirementId::class;
    }
}
