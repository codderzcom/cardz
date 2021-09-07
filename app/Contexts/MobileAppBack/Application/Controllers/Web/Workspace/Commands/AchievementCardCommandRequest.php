<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands;

final class AchievementCardCommandRequest extends BaseCommandRequest
{
    protected const RULES = [
        'planId' => 'required',
        'cardId' => 'required',
        'description' => 'required',
    ];

    protected const MESSAGES = [
        'planId.required' => 'planId required',
        'cardId.required' => 'cardId required',
        'description.required' => 'description required',
    ];

    public string $planId;

    public string $cardId;

    public string $description;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->planId = $this->input('planId');
        $this->cardId = $this->input('cardId');
        $this->description = $this->input('description');
    }
}
