<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Achievement\Commands;

use App\Contexts\Plans\Domain\Model\Achievement\AchievementId;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;

class AddAchievementRequest extends BaseCommandRequest
{
    public PlanId $planId;

    public ?string $description;

    public function passedValidation(): void
    {
        $this->planId = PlanId::of($this->input('planId'));
        $this->description = $this->input('description');
    }

    public function messages()
    {
        return [
            'description.required' => 'description required',
        ];
    }

    protected function inferAchievementId(): void
    {
        $this->achievementId = AchievementId::make();
    }
}
