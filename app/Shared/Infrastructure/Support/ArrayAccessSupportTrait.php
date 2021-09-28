<?php

namespace App\Shared\Infrastructure\Support;

use App\Shared\Exceptions\ParameterAssertionException;
use Carbon\Carbon;
use JetBrains\PhpStorm\Pure;
use Stringable;

trait ArrayAccessSupportTrait
{
    private array $arrayItems = [];

    abstract private function getItemType(): string;

    #[Pure]
    public function copy(): static
    {
        return new static(...$this->arrayItems);
    }

    public function length(): int
    {
        return count($this->arrayItems);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->arrayItems[$offset]);
    }

    public function offsetSet($offset, $value): void
    {
        if (!($value instanceof ($this->getItemType()))) {
            throw new ParameterAssertionException("Value is not an instance of " . $this->getItemType());
        }
        if (is_null($offset)) {
            $this->arrayItems[] = $value;
        } else {
            $this->arrayItems[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->arrayItems[$offset]);
    }

    public function key(): ?int
    {
        return key($this->arrayItems);
    }

    public function next(): void
    {
        next($this->arrayItems);
    }

    public function valid(): bool
    {
        return current($this->arrayItems) !== false;
    }

    public function rewind(): void
    {
        reset($this->arrayItems);
    }

    public function toArray(): array
    {
        $array = [];
        foreach ($this->arrayItems as $item) {
            $array[] = $this->toArrayNestedValue($item);
        }
        return $array;
    }

    protected function toArrayNestedValue($value): mixed
    {
        return match (true) {
            $value instanceof Carbon => $value,
            is_object($value) && method_exists($value, 'toArray') => $value->toArray(),
            $value instanceof Stringable => (string) $value,
            default => $value,
        };
    }}
