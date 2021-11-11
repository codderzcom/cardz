<?php

namespace App\Shared\Contracts\Messaging;

interface MessageChannelInterface
{
    public function __toString(): string;
}
