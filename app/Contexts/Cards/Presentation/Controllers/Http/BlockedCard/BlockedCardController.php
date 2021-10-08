<?php

namespace App\Contexts\Cards\Presentation\Controllers\Http\BlockedCard;

use App\Contexts\Cards\Application\Services\BlockedCardAppService;
use App\Contexts\Cards\Presentation\Controllers\Http\BaseController;
use App\Contexts\Cards\Presentation\Controllers\Http\BlockedCard\Commands\UnblockBlockedCardRequest;
use Illuminate\Http\JsonResponse;

class BlockedCardController extends BaseController
{
    public function __construct(
        private BlockedCardAppService $blockedCardAppService,
    ) {
    }

    public function unblock(UnblockBlockedCardRequest $request): JsonResponse
    {
        return $this->response($this->blockedCardAppService->unblockCard(
            $request->blockedCardId
        ));
    }
}
