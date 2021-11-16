<?php

namespace App\Shared\Infrastructure\Tests;

use App\Shared\Contracts\Messaging\EventBusInterface;
use App\Shared\Contracts\Messaging\EventConsumerInterface;
use App\Shared\Contracts\Messaging\EventInterface;
use App\Shared\Contracts\Messaging\MessageBrokerInterface;
use App\Shared\Infrastructure\Messaging\SimpleMessageChannel;
use Closure;

class TestEventBus implements EventBusInterface
{
    protected array $errors = [];

    protected array $events = [];

    public function __construct(
        private MessageBrokerInterface $messageBroker,
    ) {
    }

    public function publish(EventInterface ...$events): void
    {

        foreach ($events as $event) {
            $name = $event::class;
            $this->events[$name] = $event;

            $this->messageBroker->publish(SimpleMessageChannel::of($name), $event);

            if ($this->messageBroker->hasErrors()) {
                array_push($this->errors, ...$this->messageBroker->getLastErrors());
            }
        }
    }

    public function subscribe(EventConsumerInterface ...$eventConsumers): void
    {
        foreach ($eventConsumers as $eventConsumer) {
            foreach ($eventConsumer->consumes() as $channelName) {
                $this->messageBroker->subscribe(SimpleMessageChannel::of($channelName), Closure::fromCallable([$eventConsumer, 'handle']));
            }
        }
    }

    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }

    public function hasEvent(string $name): bool
    {
        return ($this->events[$name] ?? null) !== null;
    }

}
