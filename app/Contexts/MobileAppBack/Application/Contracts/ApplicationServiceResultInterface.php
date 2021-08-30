<?php

namespace App\Contexts\MobileAppBack\Application\Contracts;

interface ApplicationServiceResultInterface
{
    public function getCode(): ApplicationServiceResultCode;
    public function getPayload(): ?string;
    public function getViolation(): ?string;
    public function getError(): ?string;
}
