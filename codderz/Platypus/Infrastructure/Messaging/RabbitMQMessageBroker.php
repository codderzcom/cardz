<?php

namespace Codderz\Platypus\Infrastructure\Messaging;

use Closure;
use Codderz\Platypus\Contracts\Messaging\MessageBrokerInterface;
use Codderz\Platypus\Contracts\Messaging\MessageChannelInterface;
use Codderz\Platypus\Contracts\Messaging\MessageInterface;
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
        $this->errors = [];
        $this->subscribers[(string) $channel] ??= [];
        foreach ($this->subscribers[(string) $channel] as $subscriber) {
            foreach ($messages as $message) {
                try {
                    $subscriber(json_encode($message->jsonSerialize()));
                } catch (Throwable $exception) {
                    $this->errors[] = $exception;
                }
            }
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
