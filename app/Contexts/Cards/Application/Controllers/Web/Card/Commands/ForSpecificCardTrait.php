<?php

namespace App\Contexts\Cards\Application\Controllers\Web\Card\Commands;

use App\Contexts\Cards\Domain\Model\Card\CardId;

trait ForSpecificCardTrait
{
    public CardId $cardId;

    public function inferCardId(?string $cardId = null)
    {
        $this->cardId = new CardId($cardId);
    }

}
