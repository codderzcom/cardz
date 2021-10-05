<?php

namespace App\Shared\Contracts\Rpc;

interface RpcResponseInterface
{
    public function getCode(): int;

    public function getPayload();

    public function isOk(): bool;

    public function getRequestId(): RpcRequestIdInterface;
}
