<?php

namespace Codderz\Platypus\Infrastructure\Logging;

use Carbon\Carbon;
use Codderz\Platypus\Infrastructure\Support\ShortClassNameTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Stringable;

trait SimpleLoggerTrait
{
    use ShortClassNameTrait;

    protected function info(string $message, array $context = []): void
    {
        Log::info(self::shortName() . "::$message", $this->deObjectifyArray($context));
    }

    private function deObjectifyArray(array $items): array
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

    private function deObjectify(object $item): mixed
    {
        return match (true) {
            $item instanceof Carbon => $item,
            $item instanceof Stringable => (string) $item,
            method_exists($item, 'toArray') => $item->toArray(),
            method_exists($item, 'toJson') => $item->toJson(),
            default => json_try_encode($item),
        };
    }

    protected function error(string $message, array $context = []): void
    {
        Log::error(self::shortName() . "::$message", $this->deObjectifyArray($context));
    }
}
