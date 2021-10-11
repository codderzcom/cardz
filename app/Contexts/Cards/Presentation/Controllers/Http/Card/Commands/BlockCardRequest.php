<?php

namespace App\Contexts\Cards\Presentation\Controllers\Http\Card\Commands;

use App\Contexts\Cards\Application\Commands\BlockCard;
use App\Contexts\Cards\Application\Commands\BlockCardCommandInterface;

final class BlockCardRequest extends BaseCommandRequest
{
    public function toCommand(): BlockCardCommandInterface
    {
        return BlockCard::of($this->cardId);
    }

}
