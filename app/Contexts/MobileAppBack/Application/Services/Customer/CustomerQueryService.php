<?php

namespace App\Contexts\MobileAppBack\Application\Services\Customer;

use App\Contexts\Auth\Presentation\Controllers\Rpc\RpcAdapter as AuthRpcAdapter;
use App\Contexts\MobileAppBack\Application\Exceptions\ServiceException;
use App\Contexts\MobileAppBack\Application\Queries\Customer\GetIssuedCard;
use App\Contexts\MobileAppBack\Application\Queries\Customer\GetIssuedCards;
use App\Contexts\MobileAppBack\Application\Queries\Customer\GetToken;
use App\Contexts\MobileAppBack\Application\Queries\Customer\GetWorkspaces;
use App\Contexts\MobileAppBack\Domain\ReadModel\IssuedCard;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Customer\Contracts\CustomerWorkspaceReadStorageInterface;
use App\Contexts\MobileAppBack\Infrastructure\ReadStorage\Shared\Contracts\IssuedCardReadStorageInterface;

class CustomerQueryService
{
    public function __construct(
        private IssuedCardReadStorageInterface $issuedCardReadStorage,
        private CustomerWorkspaceReadStorageInterface $customerWorkspaceReadStorage,
        private AuthRpcAdapter $authRpcAdapter,
    ) {
    }

    public function getIssuedCard(GetIssuedCard $query): IssuedCard
    {
        return $this->issuedCardReadStorage->forCustomer($query->getCustomerId(), $query->getCardId());
    }

    public function getIssuedCards(GetIssuedCards $query): array
    {
        return $this->issuedCardReadStorage->allForCustomer($query->getCustomerId());
    }

    public function getCustomerWorkspaces(GetWorkspaces $query): array
    {
        return $this->customerWorkspaceReadStorage->all();
    }

    public function getToken(GetToken $query)
    {
        //ToDo: тут обращение к соседнему контексту. Синхронное. А по идее не должно быть
        $result = $this->authRpcAdapter->getToken($query->identity, $query->password, $query->deviceName);
        if (!$result->isOk()) {
            throw new ServiceException("Unable to get token");
        }
        return $result->getPayload();
    }
}

