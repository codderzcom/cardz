<?php

namespace App\Contexts\Personal\Presentation\Controllers\Http\Person;

use App\Contexts\Personal\Presentation\Controllers\Http\BaseController;
use App\Contexts\Personal\Presentation\Controllers\Http\Person\Commands\ChangePersonNameRequest;
use App\Shared\Contracts\Commands\CommandBusInterface;
use Illuminate\Http\JsonResponse;

class PersonController extends BaseController
{
    public function __construct(
        private CommandBusInterface $commandBus
    ) {
    }

    public function changeName(ChangePersonNameRequest $request): JsonResponse
    {
        $command = $request->toCommand();
        $this->commandBus->dispatch($command);
        return $this->response($command->getPersonId());
    }
}
