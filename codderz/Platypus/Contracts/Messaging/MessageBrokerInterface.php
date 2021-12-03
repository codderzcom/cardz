<?php

namespace Codderz\Platypus\Contracts\Messaging;

use Closure;

interface MessageBrokerInterface
{
    public function publish(MessageChannelInterface $channel, MessageInterface ...$messages): void;

    public function subscribe(MessageChannelInterface $channel, Closure $closure): void;
}
