<?php

namespace App\Contexts\Cards\Application\Controllers\Web\Card\Commands;

use App\Contexts\Cards\Domain\Model\Card\AchievementId;

class RemoveAchievementRequest extends BaseCommandRequest
{
    public AchievementId $achievementId;

    public function passedValidation(): void
    {
        $this->achievementId = new AchievementId($this->input('achievementId'));
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->merge([
            'achievementId' => $this->route('achievementId'),
        ]);
    }
}
