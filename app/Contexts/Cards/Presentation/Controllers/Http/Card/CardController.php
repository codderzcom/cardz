<?php

namespace App\Contexts\Cards\Presentation\Controllers\Http\Card;

use App\Contexts\Cards\Application\Commands\CardCommandInterface;
use App\Contexts\Cards\Presentation\Controllers\Http\BaseController;
use App\Contexts\Cards\Presentation\Controllers\Http\Card\Commands\{BlockCardRequest,
    CompleteCardRequest,
    DismissAchievementRequest,
    IssueCardRequest,
    NoteAchievementRequest,
    RevokeCardRequest,
    UnblockCardRequest
};
use App\Shared\Contracts\Commands\CommandBusInterface;
use Illuminate\Http\JsonResponse;

class CardController extends BaseController
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function issue(IssueCardRequest $request): JsonResponse
    {
        return $this->handleCommand($request->toCommand());
    }

    public function complete(CompleteCardRequest $request): JsonResponse
    {
        return $this->handleCommand($request->toCommand());
    }

    public function revoke(RevokeCardRequest $request): JsonResponse
    {
        return $this->handleCommand($request->toCommand());
    }

    public function block(BlockCardRequest $request): JsonResponse
    {
        return $this->handleCommand($request->toCommand());
    }

    public function unblock(UnblockCardRequest $request): JsonResponse
    {
        return $this->handleCommand($request->toCommand());
    }

    public function addAchievement(NoteAchievementRequest $request): JsonResponse
    {
        return $this->handleCommand($request->toCommand());
    }

    public function removeAchievement(DismissAchievementRequest $request): JsonResponse
    {
        return $this->handleCommand($request->toCommand());
    }

    private function handleCommand(CardCommandInterface $command): JsonResponse
    {
        $this->commandBus->dispatch($command);
        return $this->response($command->getCardId());
    }
}
