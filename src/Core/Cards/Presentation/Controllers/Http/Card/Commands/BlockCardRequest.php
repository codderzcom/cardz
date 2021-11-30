<?php

namespace Cardz\Core\Cards\Presentation\Controllers\Http\Card\Commands;

use Cardz\Core\Cards\Application\Commands\BlockCard;

final class BlockCardRequest extends BaseCommandRequest
{
    public function toCommand(): BlockCard
    {
        return BlockCard::of($this->cardId);
    }

}
