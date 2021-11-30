<?php

namespace Cardz\Support\Collaboration\Presentation\Controllers\Http\Relation;

use Cardz\Support\Collaboration\Presentation\Controllers\Http\BaseController;
use Cardz\Support\Collaboration\Presentation\Controllers\Http\Relation\Commands\RelationRequest;
use Codderz\Platypus\Contracts\Commands\CommandBusInterface;
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
