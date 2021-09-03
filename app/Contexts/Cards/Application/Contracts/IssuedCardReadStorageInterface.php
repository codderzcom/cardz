<?php

namespace App\Contexts\Cards\Application\Contracts;

use App\Contexts\Cards\Domain\Model\Card\CardId;
use App\Contexts\Cards\Domain\ReadModel\IssuedCard;

interface IssuedCardReadStorageInterface
{
    public function find(CardId $cardId): ?IssuedCard;
}
