<?php

namespace Codderz\Platypus\Infrastructure\Support;

use Carbon\Carbon;
use Illuminate\Support\Stringable;

trait DeObjectifyTrait
{
    protected function deObjectify(mixed $value): mixed
    {
        return match (true) {
            is_array($value) => $this->deObjectifyArray($value),
            $value instanceof Carbon => $value,
            $value instanceof Stringable => (string) $value,
            is_object($value) && method_exists($value, 'toArray') => $value->toArray(),
            is_object($value) && method_exists($value, 'toJson') => $value->toJson(),
            is_object($value) => json_try_encode($value),
            default => $value,
        };
    }

    protected function deObjectifyArray(array $items): array
    {
        $result = [];
        foreach ($items as $key => $item) {
            $result[$key] = match (true) {
                is_array($item) => $this->deObjectifyArray($item),
                is_object($item) => $this->deObjectify($item),
                default => $item,
            };
        }
        return $result;
    }
}
