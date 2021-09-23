<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands;

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

    public string $cardId;

    public string $achievementId;

    public string $description;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->cardId = $this->input('cardId');
        $this->achievementId = $this->input('achievementId');
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
