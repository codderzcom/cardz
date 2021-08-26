<?php

namespace App\Contexts\Plans\Domain\Model\Achievement;

use App\Contexts\Plans\Domain\Events\Achievement\AchievementAdded;
use App\Contexts\Plans\Domain\Events\Achievement\AchievementChanged;
use App\Contexts\Plans\Domain\Events\Achievement\AchievementRemoved;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use Carbon\Carbon;

class Achievement
{
    private ?Carbon $added = null;

    private ?Carbon $removed = null;

    public function __construct(
        public AchievementId $achievementId,
        public PlanId $planId,
        private ?string $description = null
    ) {
    }

    public function add(): AchievementAdded
    {
        $this->added = Carbon::now();
        return AchievementAdded::with($this->achievementId);
    }

    public function remove(): AchievementRemoved
    {
        $this->removed = Carbon::now();
        return AchievementRemoved::with($this->achievementId);
    }

    public function change(?string $description): AchievementChanged
    {
        $this->description = $description;
        return AchievementChanged::with($this->achievementId);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function isAdded(): bool
    {
        return $this->added === null;
    }

    public function isRemoved(): bool
    {
        return $this->removed === null;
    }
}
