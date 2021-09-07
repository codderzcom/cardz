<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Queries;

use App\Contexts\MobileAppBack\Application\Controllers\Web\Customer\Queries\BaseWorkspaceQueryRequest;

class CardByIdRequest extends BaseWorkspaceQueryRequest
{
    protected const RULES = [
        'cardId' => 'required',
    ];

    protected const MESSAGES = [
        'cardId.required' => 'cardId required',
    ];

    public string $cardId;

    public function passedValidation(): void
    {
        parent::passedValidation();
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
