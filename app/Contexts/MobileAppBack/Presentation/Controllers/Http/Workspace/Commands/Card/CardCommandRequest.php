<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\Card;

use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\BaseCommandRequest;
use App\Shared\Contracts\GeneralIdInterface;
use App\Shared\Infrastructure\Support\GuidBasedImmutableId;

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

    public GeneralIdInterface $planId;

    public GeneralIdInterface $cardId;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->planId = GuidBasedImmutableId::of($this->input('planId'));
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
