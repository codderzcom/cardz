<?php

namespace App\Contexts\MobileAppBack\Application\Services\Customer;

use App\Contexts\MobileAppBack\Domain\Card\CardCode;
use App\Contexts\MobileAppBack\Domain\Card\CardId;
use App\Contexts\MobileAppBack\Domain\Customer\CustomerCode;
use App\Contexts\MobileAppBack\Domain\Customer\CustomerId;
use App\Contexts\MobileAppBack\Infrastructure\ACL\Cards\CardsAdapter;
use App\Contexts\Shared\Contracts\ServiceResultFactoryInterface;
use App\Contexts\Shared\Contracts\ServiceResultInterface;
use App\Models\Card as EloquentCard;

class CustomerService
{
    public function __construct(
        private ServiceResultFactoryInterface $resultFactory,
        private CardsAdapter $cardsAdapter,
    ) {
    }

    public function listAllCardsByCustomer(string $customerId): ServiceResultInterface
    {
        $cards = EloquentCard::query()->where('customer_id', '=', $customerId)->get();
        return $this->resultFactory->ok($cards);
    }

    public function getCard(string $customerId, string $cardId): ServiceResultInterface
    {
        $card = EloquentCard::query()
            ->where('customer_id', '=', $customerId)
            ->where('cardId', '=', $cardId)
            ->first();
        if ($card === null) {
            return $this->resultFactory->notFound("$cardId not found");
        }
        return $this->resultFactory->ok($card);
    }

    public function getCardCode(string $customerId, string $cardId): ServiceResultInterface
    {
        $card = EloquentCard::query()
            ->where('customer_id', '=', $customerId)
            ->where('cardId', '=', $cardId)
            ->get();
        if ($card === null) {
            return $this->resultFactory->notFound("$cardId not found");
        }
        $code = CardCode::ofCardId(CardId::of($cardId));
        return $this->resultFactory->ok($code);
    }

    public function getCustomerCode(string $customerId): ServiceResultInterface
    {
        $code = CustomerCode::ofCustomerId(CustomerId::of($customerId));
        return $this->resultFactory->ok($code);
    }

}

