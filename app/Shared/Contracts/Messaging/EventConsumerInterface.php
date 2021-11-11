<?php

namespace App\Shared\Contracts\Messaging;

interface EventConsumerInterface
{
    /** string[] */
    public function consumes(): array;

    public function handle(EventInterface $event): void;
}
