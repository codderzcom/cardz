<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Card;

use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\BaseCommandRequest;
use Codderz\Platypus\Contracts\GenericIdInterface;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;

final class DismissAchievementCardRequest extends BaseCommandRequest
{
    protected const RULES = [
        'cardId' => 'required',
        'achievementId' => 'required',
    ];

    protected const MESSAGES = [
        'cardId.required' => 'cardId required',
        'achievementId.required' => 'achievementId required',
    ];

    public GenericIdInterface $cardId;

    public GenericIdInterface $achievementId;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->cardId = GuidBasedImmutableId::of($this->input('cardId'));
        $this->achievementId = GuidBasedImmutableId::of($this->input('achievementId'));
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->merge([
            'cardId' => $this->route('cardId'),
            'achievementId' => $this->route('achievementId'),
        ]);
    }
}
