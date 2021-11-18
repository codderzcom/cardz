<?php

namespace App\Contexts\Personal\Tests\Feature\Aplication\Commands;

use App\Contexts\Personal\Application\Commands\JoinPerson;
use App\Contexts\Personal\Domain\Events\Person\PersonJoined;
use App\Contexts\Personal\Domain\Model\Person\PersonId;
use App\Contexts\Personal\Tests\Feature\PersonalTestHelperTrait;
use App\Contexts\Personal\Tests\Support\Builders\PersonBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

class JoinPersonCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, PersonalTestHelperTrait;

    public function test_person_can_join()
    {
        $personTemplate = PersonBuilder::make()->build();

        $command = JoinPerson::of($personTemplate->personId, $personTemplate->name);
        $this->commandBus()->dispatch($command);

        $person = $this->getPersonRepository()->take($command->getPersonId());

        $this->assertEquals($command->getPersonId(), $person->personId);
        $this->assertTrue($person->isJoined());
        $this->assertEvent(PersonJoined::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }
}
