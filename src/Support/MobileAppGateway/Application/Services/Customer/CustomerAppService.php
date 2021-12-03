<?php

namespace Cardz\Support\MobileAppGateway\Application\Services\Customer;

use Cardz\Support\MobileAppGateway\Domain\ReadModel\Customer\IssuedCard;
use Cardz\Support\MobileAppGateway\Infrastructure\ReadStorage\Customer\Contracts\CustomerWorkspaceReadStorageInterface;
use Cardz\Support\MobileAppGateway\Infrastructure\ReadStorage\Customer\Contracts\IssuedCardReadStorageInterface;
use Cardz\Support\MobileAppGateway\Integration\Contracts\IdentityContextInterface;
use Illuminate\Support\Facades\Auth;

class CustomerAppService
{
    public function __construct(
        private IssuedCardReadStorageInterface $issuedCardReadStorage,
        private CustomerWorkspaceReadStorageInterface $customerWorkspaceReadStorage,
        private IdentityContextInterface $authContext,
    ) {
    }

    public function getCustomerId(): string
    {
        return Auth::id();
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

    public function getToken(string $identity, string $password, string $deviceName): string
    {
        return $this->authContext->getToken($identity, $password, $deviceName);
    }

    public function register(?string $email, ?string $phone, string $name, string $password, string $deviceName): string
    {
        $this->authContext->registerUser($email, $phone, $name, $password);
        return $this->authContext->getToken($email ?: $phone, $password, $deviceName);
    }
}

