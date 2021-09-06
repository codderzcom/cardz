<?php

namespace App\Contexts\Cards\Application\Contracts;

use App\Contexts\Cards\Domain\Model\Card\Card;
use App\Contexts\Cards\Domain\Model\Card\CardId;

interface CardRepositoryInterface
{
    public function persist(?Card $card = null): void;

    public function take(?CardId $cardId = null): ?Card;

    public function takeNonSatisfied(?CardId $cardId = null): ?Card;
}
