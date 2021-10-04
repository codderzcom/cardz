<?php

namespace App\Shared\Contracts\Messaging;

interface IntegrationEventConsumerInterface
{
    /** string[] */
    public function consumes(): array;

    public function handle(string $event): void;
}
