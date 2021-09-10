<?php

namespace App\Contexts\Personal\Domain\Events\Person;


use App\Contexts\Personal\Domain\Events\BaseDomainEvent;
use App\Contexts\Personal\Domain\Model\Person\PersonId;

abstract class BasePersonDomainEvent extends BaseDomainEvent
{
    protected function __construct(
        public PersonId $personId
    ) {
        parent::__construct();
    }}
