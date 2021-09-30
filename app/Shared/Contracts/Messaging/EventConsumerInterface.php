<?php

namespace App\Shared\Contracts\Messaging;

interface EventConsumerInterface
{
    public function consumes(): array;

    public function handle(EventInterface ...$events): void;
}
