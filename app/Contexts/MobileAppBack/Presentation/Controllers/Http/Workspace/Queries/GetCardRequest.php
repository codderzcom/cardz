<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Queries;

class GetCardRequest extends BaseWorkspaceQueryRequest
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
