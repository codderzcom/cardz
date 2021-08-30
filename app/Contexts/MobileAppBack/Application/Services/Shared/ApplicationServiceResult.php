<?php

namespace App\Contexts\MobileAppBack\Application\Services\Shared;

use App\Contexts\MobileAppBack\Application\Contracts\ApplicationServiceResultInterface;
use App\Contexts\MobileAppBack\Application\Contracts\ApplicationServiceResultCode;
use JetBrains\PhpStorm\Pure;

class ApplicationServiceResult implements ApplicationServiceResultInterface
{
    protected function __construct(
        protected ApplicationServiceResultCode $code,
        protected ?string $payload = null,
        protected ?string $violation = null,
        protected ?string $error = null,
    ) {
    }

    public function getPayload(): ?string
    {
        return $this->payload;
    }

    public function getCode(): ApplicationServiceResultCode
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
