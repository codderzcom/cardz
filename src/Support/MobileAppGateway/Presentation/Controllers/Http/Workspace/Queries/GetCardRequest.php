<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Queries;

use Cardz\Support\MobileAppGateway\Application\Queries\Workspace\GetCard;
use Codderz\Platypus\Contracts\GeneralIdInterface;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;

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
