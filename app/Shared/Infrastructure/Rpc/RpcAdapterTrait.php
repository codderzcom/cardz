<?php

namespace App\Shared\Infrastructure\Rpc;

use App\Shared\Contracts\Rpc\RpcResponseInterface;
use App\Shared\Infrastructure\Logging\SimpleLoggerTrait;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

trait RpcAdapterTrait
{
    use SimpleLoggerTrait;

    public function __call(string $name, array $arguments): RpcResponseInterface
    {
        $method = $name . 'Method';
        $this->info("Accepted $name call");
        if (!method_exists($this, $method)) {
            $message = "$name not found";
            $this->info($message);
            return $this->notFound();
        }

        try {
            $result = call_user_func_array([$this, $method], $arguments);
        } catch (Throwable $exception) {
            $this->error($exception->getMessage());
            return $this->exception($exception);
        }

        $this->info("$name executed", ['result' => $result]);
        return $this->ok($result);
    }

    protected function ok($payload = null): RpcResponseInterface
    {
        return RpcResponse::make(RpcRequestId::make(), Response::HTTP_OK, $payload);
    }

    protected function exception(Throwable $exception): RpcResponseInterface
    {
        return RpcResponse::make(RpcRequestId::make(), Response::HTTP_INTERNAL_SERVER_ERROR, $exception);
    }

    protected function notFound(): RpcResponseInterface
    {
        return RpcResponse::make(RpcRequestId::make(), Response::HTTP_NOT_FOUND);
    }
}
