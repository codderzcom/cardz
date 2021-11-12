<?php

namespace App\Contexts\MobileAppBack\Application\Services\Shared;

use JsonSerializable;

class ServiceResultDTO implements JsonSerializable
{
    public function __construct(protected string $name, protected $data)
    {
    }

    public static function of(string $name, $data): static
    {
        return new static($name, $data);
    }

    public function toArray(): array
    {
        return [$this->name => $this->data];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
