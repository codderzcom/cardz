<?php

namespace App\Contexts\MobileAppBack\Application\Services\Customer;

use App\Contexts\Auth\Presentation\Controllers\Rpc\RpcAdapter as AuthRpcAdapter;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Customer\Contracts\CustomerWorkspaceReadStorageInterface;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Shared\Contracts\IssuedCardReadStorageInterface;
use App\Shared\Contracts\ServiceResultFactoryInterface;
use App\Shared\Contracts\ServiceResultInterface;
use Exception;

class CustomerService
{
    public function __construct(
        private IssuedCardReadStorageInterface $issuedCardReadStorage,
        private CustomerWorkspaceReadStorageInterface $customerWorkspaceReadStorage,
        private AuthRpcAdapter $authRpcAdapter,
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

    public function getCustomerWorkspaces(): ServiceResultInterface
    {
        $workspaces = $this->customerWorkspaceReadStorage->all();
        return $this->serviceResultFactory->ok($workspaces);
    }

    public function getToken(string $identity, string $password, string $deviceName): ServiceResultInterface
    {
        //ToDo: тут обращение к соседнему контексту. Синхронное. А по идее не должно быть
        $result = $this->authRpcAdapter->getToken($identity, $password, $deviceName);
        if (!$result->isOk()) {
            //ToDo: поменять Exception
            throw new Exception();
        }
        return $this->serviceResultFactory->ok(json_decode($result->getPayload()));
    }

    public function register(?string $email, ?string $phone, string $name, string $password, string $deviceName): ServiceResultInterface
    {
        //ToDo: тут обращение к соседнему контексту. Синхронное. А по идее не должно быть
        $result = $this->authRpcAdapter->registerUser($email, $phone, $name, $password, $deviceName);
        if (!$result->isOk()) {
            //ToDo: поменять Exception
            throw new Exception();
        }
        return $this->serviceResultFactory->ok(json_decode($result->getPayload()));
    }
}

