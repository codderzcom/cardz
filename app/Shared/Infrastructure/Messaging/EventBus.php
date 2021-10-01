<?php

namespace App\Shared\Infrastructure\Messaging;

use App\Shared\Contracts\Messaging\EventBusInterface;
use App\Shared\Contracts\Messaging\EventConsumerInterface;
use App\Shared\Contracts\Messaging\EventInterface;
use App\Shared\Contracts\Messaging\IntegrationEventBusInterface;
use App\Shared\Contracts\Messaging\MessageBrokerInterface;
use App\Shared\Infrastructure\Logging\SimpleLoggerTrait;
use Closure;

class EventBus implements EventBusInterface, IntegrationEventBusInterface
{
    use SimpleLoggerTrait;

    public function __construct(
        private MessageBrokerInterface $messageBroker,
    ) {
    }

    public function publish(EventInterface ...$events): void
    {
        $this->info("Publishing", $events);
        foreach ($events as $event) {
            $name = $event::class;
            $this->messageBroker->publish(SimpleMessageChannel::of($name), $event);
            if ($this->messageBroker->hasErrors()) {
                $errors = $this->messageBroker->getLastErrors();
                $this->error("Error occurred when publishing in $name", [
                    'event' => $event,
                    'error' => end($errors),
                ]);
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
}
