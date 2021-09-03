<?php

namespace App\Contexts\Plans\Domain\Events\Requirement;

use App\Contexts\Plans\Domain\Events\BaseDomainEvent;
use App\Contexts\Plans\Domain\Model\Requirement\RequirementId;

abstract class BaseRequirementDomainEvent extends BaseDomainEvent
{
    protected function __construct(
        public RequirementId $requirementId
    ) {
        parent::__construct();
    }
}
