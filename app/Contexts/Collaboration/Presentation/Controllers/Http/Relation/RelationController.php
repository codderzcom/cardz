<?php

namespace App\Contexts\Collaboration\Presentation\Controllers\Http\Relation;

use App\Contexts\Collaboration\Presentation\Controllers\Http\BaseController;
use App\Contexts\Collaboration\Presentation\Controllers\Http\Relation\Commands\RelationRequest;
use App\Shared\Contracts\Commands\CommandBusInterface;
use Illuminate\Http\JsonResponse;

class RelationController extends BaseController
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function leave(RelationRequest $request): JsonResponse
    {
        $command = $request->toCommand();
        $this->commandBus->dispatch($command);
        return $this->response('Ok');
    }
}
