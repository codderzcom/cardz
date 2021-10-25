<?php

namespace App\Shared\Infrastructure\Logging;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Stringable;

trait SimpleLoggerTrait
{
    protected function info(string $message, array $context = []): void
    {
        Log::info($message, $this->deObjectifyArray($context));
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
        Log::error($message, $this->deObjectifyArray($context));
    }
}
