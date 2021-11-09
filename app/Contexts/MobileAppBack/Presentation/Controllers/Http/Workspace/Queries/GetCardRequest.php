<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Queries;

use App\Contexts\MobileAppBack\Application\Queries\Workspace\GetCard;

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

    public function toQuery(): GetCard
    {
        return GetCard::of($this->collaboratorId, $this->workspaceId, $this->cardId);
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->merge([
            'cardId' => $this->route('cardId'),
        ]);
    }

}
