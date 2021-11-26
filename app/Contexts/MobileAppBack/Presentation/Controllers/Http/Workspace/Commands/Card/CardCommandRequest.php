<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\Card;

use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\BaseCommandRequest;
use App\Shared\Contracts\GeneralIdInterface;
use App\Shared\Infrastructure\Support\GuidBasedImmutableId;

final class CardCommandRequest extends BaseCommandRequest
{
    protected const RULES = [
        'cardId' => 'required',
    ];

    protected const MESSAGES = [
        'cardId.required' => 'cardId required',
    ];

    public GeneralIdInterface $cardId;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->cardId = GuidBasedImmutableId::of($this->input('cardId'));
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->merge([
            'cardId' => $this->route('cardId'),
        ]);
    }
}
