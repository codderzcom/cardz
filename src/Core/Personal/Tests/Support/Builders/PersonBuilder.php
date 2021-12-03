<?php

namespace Cardz\Core\Personal\Tests\Support\Builders;

use Carbon\Carbon;
use Cardz\Core\Personal\Domain\Model\Person\Person;
use Cardz\Core\Personal\Domain\Model\Person\PersonId;
use Codderz\Platypus\Infrastructure\Tests\BaseBuilder;

final class PersonBuilder extends BaseBuilder
{
    public string $personId;

    public string $name;

    public Carbon $joined;

    public function build(): Person
    {
        return Person::restore(
            $this->personId,
            $this->name,
            $this->joined,
        );
    }

    public function generate(): static
    {
        $this->personId = PersonId::makeValue();
        $this->name = $this->faker->name();
        $this->joined = Carbon::now();
        return $this;
    }
}
