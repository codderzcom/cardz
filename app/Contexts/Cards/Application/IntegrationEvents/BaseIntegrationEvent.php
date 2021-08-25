<?php

namespace App\Contexts\Cards\Application\IntegrationEvents;

use App\Contexts\Cards\Application\Common\CardsReportable;

abstract class BaseIntegrationEvent implements CardsReportable
{
    public function __construct(protected ?string $instanceId, protected ?string $instanceOf)
    {
    }

    public function toJSON(): string
    {
        return json_try_encode($this->toArray());
    }

    public function __toString(): string
    {
        return $this->toJSON();
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
