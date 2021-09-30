<?php

namespace App\Shared\Infrastructure\Messaging;

use App\Shared\Contracts\Messaging\EventBusInterface;
use App\Shared\Contracts\Messaging\EventConsumerInterface;
use App\Shared\Contracts\Messaging\EventInterface;
use App\Shared\Infrastructure\Logging\SimpleLoggerTrait;
use Closure;

class EventBus implements EventBusInterface
{
    use SimpleLoggerTrait;

    public function __construct(
        private LocalSyncMessageBroker $messageBroker,
    ) {
    }

    public function publish(EventInterface ...$events): void
    {
        $this->info("Publishing", $events);
        $channels = [];
        foreach ($events as $event) {
            $channelName = $event::class;
            $channels[$channelName] ??= [];
            $channels[$channelName][] = $event;
        }
        foreach ($channels as $name => $eventsToPublish) {
            $this->messageBroker->publish(SimpleMessageChannel::of($name), ...$eventsToPublish);
            if ($this->messageBroker->hasErrors()) {
                $this->error("Errors occurred when publishing in $name", [
                    'events' => $eventsToPublish,
                    'errors' => $this->messageBroker->getLastErrors(),
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
