<?php

namespace App\Contexts\Auth\Presentation\Controllers\Rpc;

use App\Contexts\Auth\Application\Commands\IssueToken;
use App\Contexts\Auth\Application\Commands\RegisterUser;
use App\Contexts\Auth\Application\Services\TokenAppService;
use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Contracts\Rpc\RpcResponseInterface;
use App\Shared\Infrastructure\Rpc\RpcAdapterTrait;

/**
 * @method RpcResponseInterface registerUser(?string $email, ?string $phone, string $name, string $password, string $deviceName)
 * @method RpcResponseInterface getToken(string $identity, string $password, string $deviceName)
 */
class RpcAdapter
{
    use RpcAdapterTrait;

    public function __construct(
        private CommandBusInterface $commandBus,
        private TokenAppService $tokenAppService,
    ) {
    }

    private function registerUserMethod(?string $email, ?string $phone, string $name, string $password, string $deviceName): string
    {
        $command = RegisterUser::of($name, $password, $email, $phone);
        $this->commandBus->dispatch($command);
        return (string) $command->getUserId();
    }

    private function getTokenMethod(string $identity, string $password, string $deviceName): string
    {
        //ToDo: видимо, неправильно.
        $token = $this->tokenAppService->issueToken(IssueToken::of($identity, $password, $deviceName));
        return json_encode($token);
    }

}
