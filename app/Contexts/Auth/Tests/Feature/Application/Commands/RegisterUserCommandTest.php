<?php

namespace App\Contexts\Auth\Tests\Feature\Application\Commands;

use App\Contexts\Auth\Application\Commands\RegisterUser;
use App\Contexts\Auth\Domain\Events\User\RegistrationInitiated;
use App\Contexts\Auth\Tests\Feature\AuthTestHelperTrait;
use App\Contexts\Auth\Tests\Support\Builders\UserBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

class RegisterUserCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, AuthTestHelperTrait;

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
