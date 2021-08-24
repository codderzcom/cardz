<?php

namespace App\Contexts\Cards\Application\Controllers\Web\BlockedCard;

use App\Contexts\Cards\Application\Controllers\Web\BaseController;
use App\Contexts\Cards\Application\Controllers\Web\BlockedCard\Commands\UnblockBlockedCardRequest;
use App\Contexts\Cards\Application\IntegrationEvents\CardUnblocked;
use Illuminate\Http\JsonResponse;

class BlockedCardController extends BaseController
{
    public function unblockBlockedCard(UnblockBlockedCardRequest $unblockBlockedCardRequest): JsonResponse
    {
        return $this->successApiResponse(new CardUnblocked());
    }
}
