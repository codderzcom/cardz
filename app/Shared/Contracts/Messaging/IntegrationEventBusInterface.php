<?php

namespace App\Shared\Contracts\Messaging;

interface IntegrationEventBusInterface
{
    public function publish(EventInterface ...$events): void;

    public function subscribe(IntegrationEventConsumerInterface ...$integrationIntegrationEventConsumers): void;
}
