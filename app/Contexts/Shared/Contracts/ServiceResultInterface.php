<?php

namespace App\Contexts\Shared\Contracts;

interface ServiceResultInterface
{
    public function getCode(): ServiceResultCode;
    public function getPayload(): ?string;
    public function getViolation(): ?string;
    public function getError(): ?string;
}
