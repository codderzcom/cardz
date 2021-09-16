<?php

namespace App\Contexts\MobileAppBack\Application\Services\Customer;

use App\Contexts\Auth\Application\Services\UserAppService;
use App\Contexts\MobileAppBack\Application\Contracts\CustomerWorkspaceReadStorageInterface;
use App\Contexts\MobileAppBack\Application\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\MobileAppBack\Domain\Model\Card\CardCode;
use App\Contexts\MobileAppBack\Domain\Model\Card\CardId;
use App\Contexts\MobileAppBack\Domain\Model\Customer\CustomerCode;
use App\Contexts\MobileAppBack\Domain\Model\Customer\CustomerId;
use App\Contexts\MobileAppBack\Infrastructure\ACL\Cards\CardsAdapter;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;
use App\Models\Card as EloquentCard;

class CustomerService
{
    public function __construct(
        private IssuedCardReadStorageInterface $issuedCardReadStorage,
        private CustomerWorkspaceReadStorageInterface $customerWorkspaceReadStorage,
        private UserAppService $userAppService,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function getIssuedCard(string $customerId, string $cardId): ServiceResultInterface
    {
        $card = $this->issuedCardReadStorage->find($cardId);
        if ($card === null || $card->customerId !== $customerId) {
            return $this->serviceResultFactory->notFound("IssuedCard $cardId not found for customer $customerId");
        }
        return $this->serviceResultFactory->ok($card);
    }

    public function getIssuedCards(string $customerId): ServiceResultInterface
    {
        $cards = $this->issuedCardReadStorage->allForCustomerId($customerId);
        return $this->serviceResultFactory->ok($cards);
    }

    public function getCardCode(string $customerId, string $cardId): ServiceResultInterface
    {
        $card = $this->issuedCardReadStorage->find($cardId);
        if ($card === null || $card->customerId !== $customerId) {
            return $this->serviceResultFactory->notFound("IssuedCard $cardId not found for customer $customerId");
        }
        $code = CardCode::ofCardId(CardId::of($cardId));
        return $this->serviceResultFactory->ok($code);
    }

    public function getCustomerCode(string $customerId): ServiceResultInterface
    {
        $code = CustomerCode::ofCustomerId(CustomerId::of($customerId));
        return $this->serviceResultFactory->ok($code);
    }

    public function getCustomerWorkspaces(): ServiceResultInterface
    {
        $workspaces = $this->customerWorkspaceReadStorage->all();
        return $this->serviceResultFactory->ok($workspaces);
    }

    public function getToken(string $identity, string $password, string $deviceName): ServiceResultInterface
    {
        //ToDo: тут обращение к соседнему контексту.
        $result = $this->userAppService->getToken($identity, $password, $deviceName);
        if ($result->isNotOk()) {
            return $this->serviceResultFactory->error("Unacceptable credentials");
        }

        return $this->serviceResultFactory->ok($result->getPayload());
    }

    public function register(
        ?string $email,
        ?string $phone,
        string $name,
        string $password,
        string $deviceName
    ): ServiceResultInterface
    {
        //ToDo: тут обращение к соседнему контексту.
        $result = $this->userAppService->register($name, $password, $email, $phone);
        if ($result->isNotOk()) {
            return $result;
        }

        $identity = $email ?? $phone;
        $result = $this->userAppService->getToken($identity, $password, $deviceName);
        if ($result->isNotOk()) {
            return $this->serviceResultFactory->error("Cannot login registered user");
        }

        return $this->serviceResultFactory->ok($result->getPayload());
    }
}

