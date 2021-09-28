<?php

namespace App\Shared\Contracts;

use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;
use Stringable;

#[Immutable]
interface ServiceResultInterface extends Stringable
{
    #[Pure]
    public static function make(
        ServiceResultCode $code,
        $payload,
        ?string $violation,
        ?string $error,
        Reportable ...$reportables,
    ): ServiceResultInterface;

    public function getCode(): ServiceResultCode;

    public function getPayload();

    public function getViolation(): ?string;

    public function getError(): ?string;

    /**
     * @return Reportable[]
     */
    public function getReportables(): array;

    public function toArray(): array;

    #[Pure]
    public function ofReported(): ServiceResultInterface;

    public function isNotOk(): bool;

    public function isOk(): bool;
}
