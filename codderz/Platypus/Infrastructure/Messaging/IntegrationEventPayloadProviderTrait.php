<?php

namespace Codderz\Platypus\Infrastructure\Messaging;

use Codderz\Platypus\Infrastructure\Logging\SimpleLoggerTrait;
use JsonException;

trait IntegrationEventPayloadProviderTrait
{
    use SimpleLoggerTrait;

    protected function getPayloadOrNull(string $event, bool $logging = false): ?object
    {
        try {
            $payload = json_decode($event, false, 512, JSON_THROW_ON_ERROR)?->payload;
            return is_object($payload) ? $payload : null;
        } catch (JsonException $exception) {
            if ($logging) {
                $this->error($exception->getMessage(), [
                    'event' => $event,
                ]);
            }
            return null;
        }
    }
}
