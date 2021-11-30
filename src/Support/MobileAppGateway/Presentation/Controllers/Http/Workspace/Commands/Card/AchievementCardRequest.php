<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Card;

use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\BaseCommandRequest;
use Codderz\Platypus\Contracts\GeneralIdInterface;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;

final class AchievementCardRequest extends BaseCommandRequest
{
    protected const RULES = [
        'cardId' => 'required',
        'achievementId' => 'required',
        'description' => 'required',
    ];

    protected const MESSAGES = [
        'cardId.required' => 'cardId required',
        'achievementId.required' => 'achievementId required',
        'description.required' => 'description required',
    ];

    public GeneralIdInterface $cardId;

    public GeneralIdInterface $achievementId;

    public string $description;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->cardId = GuidBasedImmutableId::of($this->input('cardId'));
        $this->achievementId = GuidBasedImmutableId::of($this->input('achievementId'));
        $this->description = $this->input('description');
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->merge([
            'cardId' => $this->route('cardId'),
        ]);
    }
}
