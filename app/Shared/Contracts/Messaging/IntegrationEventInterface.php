<?php

namespace App\Shared\Contracts\Messaging;

interface IntegrationEventInterface extends EventInterface
{
    public function getName(): string;
}
