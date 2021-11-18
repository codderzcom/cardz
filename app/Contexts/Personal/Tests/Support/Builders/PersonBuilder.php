<?php

namespace App\Contexts\Personal\Tests\Support\Builders;

use App\Contexts\Personal\Domain\Model\Person\Person;
use App\Contexts\Personal\Domain\Model\Person\PersonId;
use App\Shared\Infrastructure\Tests\BaseBuilder;
use Carbon\Carbon;

final class PersonBuilder extends BaseBuilder
{
    private string $personId;

    private string $name;

    private Carbon $joined;

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
