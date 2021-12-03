<?php

namespace Codderz\Platypus\Contracts\Messaging;

interface IntegrationEventConsumerInterface
{
    /** string[] */
    public function consumes(): array;

    public function handle(string $event): void;
}
