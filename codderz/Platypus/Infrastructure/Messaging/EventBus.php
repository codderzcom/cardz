<?php

namespace Codderz\Platypus\Infrastructure\Messaging;

use Closure;
use Codderz\Platypus\Contracts\Messaging\EventBusInterface;
use Codderz\Platypus\Contracts\Messaging\EventConsumerInterface;
use Codderz\Platypus\Contracts\Messaging\EventInterface;
use Codderz\Platypus\Contracts\Messaging\MessageBrokerInterface;
use Codderz\Platypus\Infrastructure\Logging\SimpleLoggerTrait;
use Throwable;

class EventBus implements EventBusInterface
{
    use SimpleLoggerTrait, EventRecorderTrait;

    public function __construct(
        private MessageBrokerInterface $messageBroker,
    ) {
    }

    public function publish(EventInterface ...$events): void
    {
        $this->info("Publishing: ", $events);
        foreach ($events as $event) {
            $name = $event::class;
            $this->recordEvent($name, $event);
            $this->messageBroker->publish(SimpleMessageChannel::of($name), $event);

            if ($this->messageBroker->hasErrors()) {
                $this->logPublicationErrors($event, ...$this->messageBroker->getLastErrors());
            }
        }
    }

    private function logPublicationErrors(EventInterface $event, Throwable ...$throwables): void
    {
        /** @var Throwable $error */
        $error = end($throwables);
        $this->error('Error occurred when publishing in ' . $event::class, [
            'event' => $event,
            'error' => $error->getMessage(),
        ]);
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
