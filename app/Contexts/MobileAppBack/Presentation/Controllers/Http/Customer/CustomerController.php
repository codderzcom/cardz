<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer;

use App\Contexts\MobileAppBack\Presentation\Controllers\Http\BaseController;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer\Queries\GetIssuedCardRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer\Queries\GetIssuedCardsRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer\Queries\GetTokenRequest;
use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Customer\Queries\RegisterRequest;
use App\Shared\Contracts\Commands\CommandBusInterface;
use App\Shared\Contracts\Queries\QueryBusInterface;
use Illuminate\Http\JsonResponse;

class CustomerController extends BaseController
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus,
    ) {
    }

    public function getToken(GetTokenRequest $request): JsonResponse
    {
        return $this->response($this->queryBus->execute($request->toQuery()));
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $command = $request->toCommand();
        $query = $request->toQuery();
        // ToDo: Warning! Sync execution. Incorrect?
        $this->commandBus->dispatch($command);
        return $this->response($this->queryBus->execute($query));
    }

    public function getCards(GetIssuedCardsRequest $request): JsonResponse
    {
        return $this->response($this->queryBus->execute($request->toQuery()));
    }

    public function getCard(GetIssuedCardRequest $request): JsonResponse
    {
        return $this->response($this->queryBus->execute($request->toQuery()));
    }

}
