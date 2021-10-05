<?php

namespace App\Shared\Infrastructure\Rpc;

use App\Shared\Contracts\Rpc\RpcRequestIdInterface;
use App\Shared\Contracts\Rpc\RpcResponseInterface;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Response;

class RpcResponse implements RpcResponseInterface
{

    private function __construct(
        private RpcRequestIdInterface $requestId,
        private $code,
        private $payload,
    ) {
    }

    #[Pure]
    public static function make(RpcRequestIdInterface $requestId, $code = Response::HTTP_OK, $payload = null): static
    {
        return new static($requestId, $code, $payload);
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function isOk(): bool
    {
        return $this->code === Response::HTTP_OK;
    }

    public function getRequestId(): RpcRequestIdInterface
    {
        return $this->requestId;
    }
}
