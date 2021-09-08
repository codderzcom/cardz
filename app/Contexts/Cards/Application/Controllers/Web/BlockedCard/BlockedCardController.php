<?php

namespace App\Contexts\Cards\Application\Controllers\Web\BlockedCard;

use App\Contexts\Cards\Application\Controllers\Web\BaseController;
use App\Contexts\Cards\Application\Controllers\Web\BlockedCard\Commands\UnblockBlockedCardRequest;
use App\Contexts\Cards\Application\Services\BlockedCardAppService;
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
