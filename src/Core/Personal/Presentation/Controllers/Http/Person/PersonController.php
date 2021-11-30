<?php

namespace Cardz\Core\Personal\Presentation\Controllers\Http\Person;

use Cardz\Core\Personal\Presentation\Controllers\Http\BaseController;
use Cardz\Core\Personal\Presentation\Controllers\Http\Person\Commands\ChangePersonNameRequest;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
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
