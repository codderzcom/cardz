<?php

namespace App\Contexts\Plans\Domain\Events\Achievement;

use App\Contexts\Plans\Domain\Events\BaseDomainEvent;
use App\Contexts\Plans\Domain\Model\Achievement\AchievementId;

abstract class BaseAchievementDomainEvent extends BaseDomainEvent
{
    protected function __construct(
        public AchievementId $achievementId
    ) {
        parent::__construct();
    }
}
