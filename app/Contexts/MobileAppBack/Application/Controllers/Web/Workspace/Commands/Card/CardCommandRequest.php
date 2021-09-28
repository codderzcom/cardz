<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands\Card;

use App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands\BaseCommandRequest;

final class CardCommandRequest extends BaseCommandRequest
{
    protected const RULES = [
        'planId' => 'required',
        'cardId' => 'required',
    ];

    protected const MESSAGES = [
        'planId.required' => 'planId required',
        'cardId.required' => 'cardId required',
    ];

    public string $planId;

    public string $cardId;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->planId = $this->input('planId');
        $this->cardId = $this->input('cardId');
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->merge([
            'cardId' => $this->route('cardId'),
        ]);
    }
}
