<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Customer;

use Cardz\Support\MobileAppGateway\Application\Services\Customer\CustomerAppService;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\BaseController;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Customer\Requests\GetIssuedCardRequest;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Customer\Requests\GetIssuedCardsRequest;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Customer\Requests\GetTokenRequest;
use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Customer\Requests\RegisterRequest;
use Cardz\Support\MobileAppGateway\Presentation\Documentation\Customer\Requests\RegisterRequestBody;
use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Guid\Guid;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class CustomerController extends BaseController
{
    public function __construct(
        private CustomerAppService $customerAppService,
    ) {
    }

    /**
     * Get authorized user id
     *
     * Returns id of the authenticated user.
     */
    #[OpenApi\Operation(tags: ['customer'])]
    public function getId(): JsonResponse
    {
        return $this->response($this->customerAppService->getCustomerId());
    }

    /**
     * Get user token
     *
     * Returns new API user token (for basic bearer auth). Requires identity, password and device name.
     */
    #[OpenApi\Operation(tags: ['customer'])]
    public function getToken(GetTokenRequest $request): JsonResponse
    {
        return $this->response($this->customerAppService->getToken(
            $request->identity,
            $request->password,
            $request->deviceName,
        ));
    }

    /**
     * Register user
     *
     * Registers new user with email OR phone, password, device name (for token). Returns new auth token.
     */
    #[OpenApi\Operation(tags: ['customer'])]
    #[OpenApi\RequestBody(factory: RegisterRequestBody::class)]
    public function register(RegisterRequest $request): JsonResponse
    {
        return $this->response($this->customerAppService->register(
            $request->email,
            $request->phone,
            $request->name,
            $request->password,
            $request->deviceName,
        ));
    }

    /**
     * User cards
     *
     * Returns all active cards for the current user.
     */
    #[OpenApi\Operation(tags: ['customer'])]
    public function getCards(GetIssuedCardsRequest $request): JsonResponse
    {
        return $this->response($this->customerAppService->getIssuedCards($request->customerId));
    }

    /**
     * User card
     *
     * Returns an active card, owned by the current user, by its id.
     * @param Guid $cardId Card GUID
     */
    #[OpenApi\Operation(tags: ['customer'])]
    public function getCard(GetIssuedCardRequest $request): JsonResponse
    {
        return $this->response($this->customerAppService->getIssuedCard($request->customerId, $request->cardId));
    }

    /**
     * Workspaces
     *
     * Returns all workspaces
     */
    #[OpenApi\Operation(tags: ['customer'])]
    public function getWorkspaces(): JsonResponse
    {
        return $this->response($this->customerAppService->getCustomerWorkspaces());
    }

}
