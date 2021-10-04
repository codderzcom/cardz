<?php

namespace App\Shared\Infrastructure\Messaging;

use App\Shared\Contracts\Messaging\MessageBrokerInterface;
use App\Shared\Contracts\Messaging\MessageChannelInterface;
use App\Shared\Contracts\Messaging\MessageInterface;
use Closure;
use Throwable;

//ToDo: fake: replace
class RabbitMQMessageBroker implements MessageBrokerInterface
{
    /**
     * @var array[]
     */
    private array $subscribers = [];

    /**
     * @var Throwable[]
     */
    private array $errors = [];

    public function publish(MessageChannelInterface $channel, MessageInterface ...$messages): void
    {
        try {
            $this->errors = [];
            $this->subscribers[(string) $channel] ??= [];
            foreach ($this->subscribers[(string) $channel] as $subscriber) {
                foreach ($messages as $message) {
                    $subscriber(json_encode($message->jsonSerialize()));
                }
            }
        } catch (Throwable $exception) {
            $this->errors[] = $exception;
        }
    }

    public function subscribe(MessageChannelInterface $channel, Closure $closure): void
    {
        $this->subscribers[(string) $channel] ??= [];
        $this->subscribers[(string) $channel][] = $closure;
    }

    /**
     * @return Throwable[]
     */
    public function getLastErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }
}
