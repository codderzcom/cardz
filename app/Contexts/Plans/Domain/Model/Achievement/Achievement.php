<?php

namespace App\Contexts\Plans\Domain\Model\Achievement;

use App\Contexts\Plans\Domain\Events\Achievement\AchievementAdded;
use App\Contexts\Plans\Domain\Events\Achievement\AchievementChanged;
use App\Contexts\Plans\Domain\Events\Achievement\AchievementRemoved;
use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Domain\Model\Shared\AggregateRoot;
use App\Contexts\Plans\Domain\Model\Shared\Description;
use Carbon\Carbon;
use JetBrains\PhpStorm\Pure;

final class Achievement extends AggregateRoot
{
    private ?Carbon $added = null;

    private ?Carbon $removed = null;

    private function __construct(
        public AchievementId $achievementId,
        public PlanId $planId,
        private Description $description,
    ) {
    }

    #[Pure]
    public static function make(AchievementId $achievementId, PlanId $planId, Description $description): self
    {
        return new self($achievementId, $planId, $description);
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

    public function change(Description $description): AchievementChanged
    {
        $this->description = $description;
        return AchievementChanged::with($this->achievementId);
    }

    public function getDescription(): Description
    {
        return $this->description;
    }

    public function isAdded(): bool
    {
        return $this->added !== null;
    }

    public function isRemoved(): bool
    {
        return $this->removed !== null;
    }

    private function from(
        string $achievementId,
        string $planId,
        string $description = null,
        ?Carbon $added = null,
        ?Carbon $removed = null,
    ): void {
        $this->achievementId = AchievementId::of($achievementId);
        $this->planId = PlanId::of($planId);
        $this->description = Description::of($description);
        $this->added = $added;
        $this->removed = $removed;
    }
}
