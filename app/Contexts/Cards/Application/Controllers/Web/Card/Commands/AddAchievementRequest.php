<?php

namespace App\Contexts\Cards\Application\Controllers\Web\Card\Commands;

class AddAchievementRequest extends BaseCommandRequest
{
    use ForSpecificCardTrait;

    public function getDescription(): string
    {
        return $this->get('description') ?? 'Error';
    }
}
