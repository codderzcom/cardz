<?php

namespace App\Contexts\MobileAppBack\Application\Services\Customer;

use App\Contexts\Auth\Application\Commands\IssueToken;
use App\Contexts\Auth\Application\Commands\RegisterUser;
use App\Contexts\Auth\Application\Services\TokenAppService;
use App\Contexts\Auth\Application\Services\UserAppService;
use App\Contexts\MobileAppBack\Application\Contracts\CustomerWorkspaceReadStorageInterface;
use App\Contexts\MobileAppBack\Application\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\MobileAppBack\Domain\Model\Card\CardCode;
use App\Contexts\MobileAppBack\Domain\Model\Card\CardId;
use App\Contexts\MobileAppBack\Domain\Model\Customer\CustomerCode;
use App\Contexts\MobileAppBack\Domain\Model\Customer\CustomerId;
use App\Shared\Contracts\ServiceResultFactoryInterface;
use App\Shared\Contracts\ServiceResultInterface;

class CustomerService
{
    public function __construct(
        private IssuedCardReadStorageInterface $issuedCardReadStorage,
        private CustomerWorkspaceReadStorageInterface $customerWorkspaceReadStorage,
        private UserAppService $userAppService,
        private TokenAppService $tokenAppService,
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
        //ToDo: тут обращение к соседнему контексту. Синхронное. А по идее не должно быть
        $token = $this->tokenAppService->issueToken(IssueToken::of($identity, $password, $deviceName));
        return $this->serviceResultFactory->ok($token);
    }

    public function register(
        ?string $email,
        ?string $phone,
        string $name,
        string $password,
        string $deviceName
    ): ServiceResultInterface {
        //ToDo: тут обращение к соседнему контексту. Синхронное. А по идее не должно быть
        $this->userAppService->register(RegisterUser::of($name, $password, $email, $phone));
        return $this->getToken($email ?? $phone, $password, $deviceName);
    }
}

