<?php

namespace App\Contexts\Cards\Application\Services;

use App\Contexts\Cards\Application\Contracts\IssuedCardReadStorageInterface;
use App\Shared\Contracts\ServiceResultFactoryInterface;
use App\Shared\Contracts\ServiceResultInterface;

class ReadIssuedCardAppService
{

    public function __construct(
        private IssuedCardReadStorageInterface $issuedCardReadStorage,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function getIssuedCard(string $cardId): ServiceResultInterface
    {
        $card = $this->issuedCardReadStorage->find($cardId);
        if ($card === null) {
            return $this->serviceResultFactory->notFound("IssuedCard not found for $cardId");
        }
        return $this->serviceResultFactory->ok($card);
    }
}
