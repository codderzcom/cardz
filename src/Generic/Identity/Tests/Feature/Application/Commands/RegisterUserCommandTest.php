<?php

namespace Cardz\Generic\Identity\Tests\Feature\Application\Commands;

use Cardz\Generic\Identity\Application\Commands\RegisterUser;
use Cardz\Generic\Identity\Domain\Events\User\RegistrationInitiated;
use Cardz\Generic\Identity\Tests\Feature\IdentityTestHelperTrait;
use Cardz\Generic\Identity\Tests\Support\Builders\UserBuilder;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

class RegisterUserCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, IdentityTestHelperTrait;

    public function test_user_can_be_registered()
    {
        $userBuilder = UserBuilder::make();
        $command = RegisterUser::of($userBuilder->name, $userBuilder->plainTextPassword, $userBuilder->email, $userBuilder->phone);
        $this->commandBus()->dispatch($command);

        $user = $this->getUserRepository()->takeByIdentity($command->getUserIdentity());

        $this->assertEquals($command->getUserIdentity(), $user->identity);
        $this->assertEvent(RegistrationInitiated::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }
}
