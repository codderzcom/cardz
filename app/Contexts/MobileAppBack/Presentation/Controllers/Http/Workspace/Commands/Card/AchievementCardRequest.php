<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\Card;

use App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands\BaseCommandRequest;
use App\Shared\Contracts\GeneralIdInterface;
use App\Shared\Infrastructure\Support\GuidBasedImmutableId;

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
