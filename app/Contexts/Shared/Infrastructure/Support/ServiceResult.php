<?php

namespace App\Contexts\Shared\Infrastructure\Support;

use App\Contexts\Shared\Contracts\Reportable;
use App\Contexts\Shared\Contracts\ServiceResultCode;
use App\Contexts\Shared\Contracts\ServiceResultInterface;
use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;
use Stringable;
use function json_try_encode;

#[Immutable]
class ServiceResult implements ServiceResultInterface
{
    /**
     * @var Reportable[]
     */
    protected array $reportables;

    protected function __construct(
        protected ServiceResultCode $code,
        protected $payload,
        protected ?string $violation,
        protected ?string $error,
        Reportable ...$reportables,
    ) {
        $this->reportables = $reportables ?? [];
    }

    #[Pure]
    public static function make(
        ServiceResultCode $code,
        $payload,
        ?string $violation,
        ?string $error,
        Reportable ...$reportables,
    ): ServiceResultInterface {
        return new static($code, $payload, $violation, $error, ...$reportables);
    }

    public function getPayload()
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

    /**
     * @return Reportable[]
     */
    public function getReportables(): array
    {
        return $this->reportables;
    }

    public function toArray(): array
    {
        $payload = match (true) {
            is_object($this->payload) && method_exists($this->payload, 'toArray') => $this->payload->toArray(),
            $this->payload instanceof Stringable => (string) $this->payload,
            default => $this->payload,
        };
        return [
            'code' => $this->code,
            'payload' => $payload,
            'violation' => $this->violation,
            'error' => $this->error,
        ];
    }

    public function __toString(): string
    {
        return json_try_encode($this->toArray());
    }

    #[Pure]
    public function ofReported(): ServiceResultInterface
    {
        return new self($this->code, $this->payload, $this->violation, $this->error);
    }

    public function isNotOk(): bool
    {
        return $this->code->equals(ServiceResultCode::OK());
    }
}
