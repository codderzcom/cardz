<?php

namespace App\Shared\Infrastructure\Messaging;

use App\Shared\Contracts\Messaging\EventInterface;
use App\Shared\Contracts\Messaging\IntegrationEventBusInterface;
use App\Shared\Contracts\Messaging\IntegrationEventConsumerInterface;
use App\Shared\Contracts\Messaging\MessageBrokerInterface;
use App\Shared\Infrastructure\Logging\SimpleLoggerTrait;
use Closure;
use Throwable;

class IntegrationEventBus implements IntegrationEventBusInterface
{
    use SimpleLoggerTrait;

    public function __construct(
        private MessageBrokerInterface $messageBroker,
    ) {
    }

    public function publish(EventInterface ...$events): void
    {
        $this->info("Integration event(s): ", $events);
        foreach ($events as $event) {
            $name = $event::class;
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
        $this->error('Error occurred when publishing an integration event ' . $event::class, [
            'event' => $event,
            'error' => $error->getMessage(),
        ]);
    }

    public function subscribe(IntegrationEventConsumerInterface ...$integrationEventConsumers): void
    {
        foreach ($integrationEventConsumers as $eventConsumer) {
            foreach ($eventConsumer->consumes() as $channelName) {
                $this->messageBroker->subscribe(SimpleMessageChannel::of($channelName), Closure::fromCallable([$eventConsumer, 'handle']));
            }
        }
    }
}
