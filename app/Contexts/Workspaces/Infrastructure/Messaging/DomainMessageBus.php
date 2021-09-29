<?php

namespace App\Contexts\Workspaces\Infrastructure\Messaging;

use App\Shared\Contracts\Domain\DomainEventInterface;
use App\Shared\Infrastructure\Logging\SimpleLoggerTrait;
use App\Shared\Infrastructure\Messaging\LocalSyncMessageBroker;
use App\Shared\Infrastructure\Messaging\SimpleMessageChannel;

class DomainMessageBus
{
    use SimpleLoggerTrait;

    public function __construct(
        private LocalSyncMessageBroker $messageBroker,
    ) {
    }

    public function publish(DomainEventInterface ...$domainEvents): void
    {
        $this->info("Publishing", $domainEvents);
        $channels = [];
        foreach ($domainEvents as $domainEvent) {
            $channelName = $domainEvent::class;
            $channels[$channelName] ??= [];
            $channels[$channelName] = $domainEvent;
        }
        foreach ($channels as $name => $events) {
            $this->messageBroker->publish(SimpleMessageChannel::of($name), ...$events);
            if ($this->messageBroker->hasErrors()) {
                $this->error("Errors occurred publishing in $name", $events);
            }
        }
    }

    public function subscribe(): void
    {
        // $this->messageBroker->subscribe();
    }
}
