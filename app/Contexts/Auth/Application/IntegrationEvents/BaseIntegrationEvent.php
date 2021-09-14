<?php

namespace App\Contexts\Auth\Application\IntegrationEvents;

use App\Contexts\Shared\Contracts\Reportable;

abstract class BaseIntegrationEvent implements Reportable
{
    protected ?string $instanceOf = null;

    public function __construct(protected ?string $instanceId)
    {
    }

    public function __toString(): string
    {
        return $this->toJSON();
    }

    public function toJSON(): string
    {
        return json_try_encode($this->toArray());
    }

    protected function toArray(): array
    {
        return [
            'instance' => [
                'id' => $this->instanceId,
                'of' => $this->instanceOf,
            ],
            'happened' => static::class,
        ];
    }

    public function getInstanceId(): ?string
    {
        return $this->instanceId;
    }

    public function getInstanceOf(): ?string
    {
        return $this->instanceOf;
    }
}
