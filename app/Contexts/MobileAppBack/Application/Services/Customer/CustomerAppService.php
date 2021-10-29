<?php

namespace App\Contexts\MobileAppBack\Application\Services\Customer;

use App\Contexts\Auth\Presentation\Controllers\Rpc\RpcAdapter as AuthRpcAdapter;
use App\Contexts\MobileAppBack\Application\Exceptions\ServiceException;
use App\Contexts\MobileAppBack\Domain\ReadModel\IssuedCard;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Customer\Contracts\CustomerWorkspaceReadStorageInterface;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Shared\Contracts\IssuedCardReadStorageInterface;
use App\Contexts\MobileAppBack\Integration\Contracts\AuthContextInterface;

class CustomerAppService
{
    public function __construct(
        private IssuedCardReadStorageInterface $issuedCardReadStorage,
        private CustomerWorkspaceReadStorageInterface $customerWorkspaceReadStorage,
        private AuthContextInterface $authContext,
    ) {
    }

    public function getIssuedCard(string $customerId, string $cardId): IssuedCard
    {
        return $this->issuedCardReadStorage->forCustomer($customerId, $cardId);
    }

    public function getIssuedCards(string $customerId): array
    {
        return $this->issuedCardReadStorage->allForCustomer($customerId);
    }

    public function getCustomerWorkspaces(): array
    {
        return $this->customerWorkspaceReadStorage->all();
    }

    public function issueToken(string $identity, string $password, string $deviceName): string
    {
        return $this->authContext->issueToken($identity, $password, $deviceName);
    }

    public function register(?string $email, ?string $phone, string $name, string $password, string $deviceName): string
    {
        return $this->authContext->registerUser($email, $phone, $name, $password, $deviceName);
    }
}

