<?php

namespace App\Contexts\Workspaces\Presentation\Controllers\Rpc;

use App\Contexts\Workspaces\Application\Commands\AddWorkspace;
use App\Contexts\Workspaces\Application\Commands\ChangeWorkspaceProfile;
use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Contracts\ServiceResultFactoryInterface;
use App\Shared\Contracts\ServiceResultInterface;
use App\Shared\Infrastructure\Logging\SimpleLoggerTrait;
use Throwable;

/**
 * @method ServiceResultInterface addWorkspace(string $keeperId, string $name, string $description, string $address)
 * @method ServiceResultInterface changeProfile(string $workspaceId, string $name, string $description, string $address)
 */
class RpcAdapter
{
    use SimpleLoggerTrait;

    public function __construct(
        private CommandBusInterface $commandBus,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    //ToDo: think, not good.
    public function __call(string $name, array $arguments): ServiceResultInterface
    {
        $method = $name. 'Method';
        $this->info("Accepted $name call");
        if (!method_exists($this, $method)) {
            $message = "$name not found";
            $this->info($message);
            return $this->serviceResultFactory->notFound($message);
        }

        try {
            $result = call_user_func_array([$this, $method], $arguments);
        } catch (Throwable $exception) {
            $this->error($exception->getMessage());
            return $this->serviceResultFactory->error($exception->getMessage());
        }
        $this->info("$name executed", [
            'result' => $result,
        ]);

        return $this->serviceResultFactory->ok($result);
    }

    private function addWorkspaceMethod(string $keeperId, string $name, string $description, string $address): void
    {
        $command = AddWorkspace::of($keeperId, $name, $description, $address);
        $this->commandBus->dispatch($command);
    }

    private function changeProfileMethod(string $workspaceId, string $name, string $description, string $address): void
    {
        $command = ChangeWorkspaceProfile::of($workspaceId, $name, $description, $address);
        $this->commandBus->dispatch($command);
    }
}
