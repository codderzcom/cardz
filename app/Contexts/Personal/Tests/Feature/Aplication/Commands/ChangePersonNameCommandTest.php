<?php

namespace App\Contexts\Personal\Tests\Feature\Aplication\Commands;

use App\Contexts\Personal\Application\Commands\ChangePersonName;
use App\Contexts\Personal\Domain\Events\Person\PersonNameChanged;
use App\Contexts\Personal\Tests\Feature\PersonalTestHelperTrait;
use App\Contexts\Personal\Tests\Support\Builders\PersonBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

class ChangePersonNameCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, PersonalTestHelperTrait;

    public function test_person_can_change_name()
    {
        $person = PersonBuilder::make()->build();
        $this->getPersonRepository()->persist($person);

        $command = ChangePersonName::of($person->personId, 'Changed');
        $this->commandBus()->dispatch($command);

        $person = $this->getPersonRepository()->take($command->getPersonId());

        $this->assertEquals('Changed', $person->name);
        $this->assertEvent(PersonNameChanged::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }
}
