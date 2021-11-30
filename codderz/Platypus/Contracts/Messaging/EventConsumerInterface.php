<?php

namespace Codderz\Platypus\Contracts\Messaging;

interface EventConsumerInterface
{
    /** string[] */
    public function consumes(): array;

    public function handle(EventInterface $event): void;
}
