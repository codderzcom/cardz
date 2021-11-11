<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Queries;

use App\Contexts\MobileAppBack\Application\Queries\Workspace\GetCard;
use App\Shared\Contracts\GeneralIdInterface;
use App\Shared\Infrastructure\Support\GuidBasedImmutableId;

class GetCardRequest extends BaseWorkspaceQueryRequest
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
