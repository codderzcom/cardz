<?php

namespace App\Contexts\Plans\Domain\Model\Achievement;

use App\Contexts\Shared\Exceptions\ParameterAssertionException;
use ArrayAccess;
use Iterator;
use JetBrains\PhpStorm\Pure;

class AchievementCollection implements ArrayAccess, Iterator
{
    /** @var Achievement[] */
    private array $achievements;

    public function __construct(Achievement ...$achievements)
    {
        $this->achievements = $achievements ?? [];
    }

    #[Pure]
    public function copy(): AchievementCollection
    {
        return new static(...$this->achievements);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->achievements[$offset]);
    }

    public function offsetGet($offset): Achievement
    {
        return $this->achievements[$offset];
    }

    /**
     * @param mixed $offset
     * @param Achievement $value
     */
    public function offsetSet($offset, $value): void
    {
        if (!($value instanceof Achievement)) {
            throw new ParameterAssertionException("Value is not an achievement");
        }
        $this->achievements[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->achievements[$offset]);
    }

    public function current(): Achievement
    {
        return current($this->achievements);
    }

    public function next(): Achievement
    {
        return next($this->achievements);
    }

    public function key(): ?int
    {
        return key($this->achievements);
    }

    public function valid(): bool
    {
        return current($this->achievements) !== false;
    }

    public function rewind(): void
    {
        reset($this->achievements);
    }
}
