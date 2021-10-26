<?php

namespace App\Contexts\Cards\Presentation\Controllers\Http\Card\Commands;

use App\Contexts\Cards\Application\Commands\BlockCard;

final class BlockCardRequest extends BaseCommandRequest
{
    public function toCommand(): BlockCard
    {
        return BlockCard::of($this->cardId);
    }

}
