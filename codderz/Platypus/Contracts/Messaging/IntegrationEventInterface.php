<?php

namespace Codderz\Platypus\Contracts\Messaging;

interface IntegrationEventInterface extends EventInterface
{
    public function getName(): string;
}
