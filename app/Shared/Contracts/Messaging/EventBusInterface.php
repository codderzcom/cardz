<?php

namespace App\Shared\Contracts\Messaging;

use Closure;

interface EventBusInterface
{
    public function publish(EventInterface ...$events): void;

    public function subscribe(EventConsumerInterface ...$eventConsumers): void;
}
