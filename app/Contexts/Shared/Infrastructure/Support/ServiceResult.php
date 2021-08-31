<?php

namespace App\Contexts\Shared\Infrastructure\Support;

use App\Contexts\Shared\Contracts\ServiceResultCode;
use App\Contexts\Shared\Contracts\ServiceResultInterface;
use JetBrains\PhpStorm\Pure;
use function json_try_encode;

class ServiceResult implements ServiceResultInterface
{
    protected function __construct(
        protected ServiceResultCode $code,
        protected ?string $payload = null,
        protected ?string $violation = null,
        protected ?string $error = null,
    ) {
    }

    public function getPayload(): ?string
    {
        return $this->payload;
    }

    public function getCode(): ServiceResultCode
    {
        return $this->code;
    }

    public function getViolation(): ?string
    {
        return $this->violation;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    #[Pure]
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'payload' => $this->payload,
            'violation' => $this->violation,
            'error' => $this->error,
        ];
    }

    public function __toString(): string
    {
        return json_try_encode($this->toArray());
    }
}
