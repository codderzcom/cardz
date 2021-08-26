<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Achievement\Commands;

use App\Contexts\Plans\Domain\Model\Achievement\AchievementId;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;

class AddAchievementRequest extends BaseCommandRequest
{
    public PlanId $planId;

    public ?string $description;

    protected function inferAchievementId(): void
    {
        $this->achievementId = new AchievementId();
    }

    public function passedValidation(): void
    {
        $this->planId = new PlanId($this->input('planId'));
        $this->description = $this->input('description');
    }

    public function messages()
    {
        return [
            'description.required' => 'description required',
        ];
    }
}
