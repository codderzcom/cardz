<?php

namespace Cardz\Core\Cards\Presentation\Controllers\Http\Card\Commands;

use Cardz\Core\Cards\Application\Commands\CompleteCard;

final class CompleteCardRequest extends BaseCommandRequest
{
    public function toCommand(): CompleteCard
    {
        return CompleteCard::of($this->cardId);
    }
}
