<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Card;

use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\BaseCommandRequest;
use Codderz\Platypus\Contracts\GenericIdInterface;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;

final class CardCommandRequest extends BaseCommandRequest
{
    protected const RULES = [
        'cardId' => 'required',
    ];

    protected const MESSAGES = [
        'cardId.required' => 'cardId required',
    ];

    public GenericIdInterface $cardId;

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
