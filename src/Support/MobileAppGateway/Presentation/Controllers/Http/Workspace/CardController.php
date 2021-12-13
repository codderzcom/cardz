<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace;

use Cardz\Support\MobileAppGateway\Application\Services\Workspace\CardAppService;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\BaseController;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Card\AchievementCardRequest;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Card\CardCommandRequest;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Card\IssueCardRequest;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Queries\GetCardRequest;
use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Guid\Guid;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class CardController extends BaseController
{
    public function __construct(
        private CardAppService $cardService,
    ) {
    }

    /**
     * Get card
     *
     * Returns card by card id if it is issued in the current workspace.
     * Requires user to be authorized to work in the current workspace.
     *
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $cardId Card GUID
     */
    #[OpenApi\Operation(tags: ['business', 'card'])]
    public function getCard(GetCardRequest $request): JsonResponse
    {
        return $this->response($this->cardService->getCard($request->cardId));
    }

    /**
     * Issue card
     *
     * Issues card for a plan to a customer.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     */
    #[OpenApi\Operation(tags: ['business', 'card'])]
    public function issue(IssueCardRequest $request): JsonResponse
    {
        return $this->response($this->cardService->issue($request->planId, $request->customerId));
    }

    /**
     * Complete card
     *
     * Marks card as completed, meaning the owner has received their bonus.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $cardId Card GUID
     */
    #[OpenApi\Operation(tags: ['business', 'card'])]
    public function complete(CardCommandRequest $request): JsonResponse
    {
        return $this->response($this->cardService->complete($request->cardId));
    }

    /**
     * Revoke card
     *
     * Marks card as revoked, meaning the owner cannot use and even see it anymore.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $cardId Card GUID
     */
    #[OpenApi\Operation(tags: ['business', 'card'])]
    public function revoke(CardCommandRequest $request): JsonResponse
    {
        return $this->response($this->cardService->revoke($request->cardId));
    }

    /**
     * Block card
     *
     * Marks card as blocked, meaning the owner cannot use it temporarily until it's unblocked.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $cardId Card GUID
     */
    #[OpenApi\Operation(tags: ['business', 'card'])]
    public function block(CardCommandRequest $request): JsonResponse
    {
        return $this->response($this->cardService->block($request->cardId));
    }

    /**
     * Unblock card
     *
     * Marks card as unblocked, meaning the owner can interact with it again.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $cardId Card GUID
     */
    #[OpenApi\Operation(tags: ['business', 'card'])]
    public function unblock(CardCommandRequest $request): JsonResponse
    {
        return $this->response($this->cardService->unblock($request->cardId));
    }

    /**
     * Note achievement to the card
     *
     * Marks one of the Plan requirements as achieved in the customer card.
     * Card will be marked as satisfied shortly after the last requirement is marked.
     * Meaning the card owner is now legible for the bonus.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $cardId Card GUID
     */
    #[OpenApi\Operation(tags: ['business', 'card'])]
    public function noteAchievement(AchievementCardRequest $request): JsonResponse
    {
        return $this->response($this->cardService->noteAchievement($request->cardId, $request->achievementId, $request->description));
    }

    /**
     * Dismiss achievement from the card
     *
     * Removes achievement and removes satisfaction mark from the card if necessary.
     * Can only be done until the card owner received their bonus.
     * Requires user to be authorized to work in the current workspace.
     * @param Guid $workspaceId Workspace GUID
     * @param Guid $cardId Card GUID
     */
    #[OpenApi\Operation(tags: ['business', 'card'])]
    public function dismissAchievement(AchievementCardRequest $request): JsonResponse
    {
        return $this->response($this->cardService->dismissAchievement($request->cardId, $request->achievementId));
    }

}
