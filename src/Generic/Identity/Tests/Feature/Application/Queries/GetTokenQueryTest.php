<?php

namespace Cardz\Generic\Identity\Tests\Feature\Application\Queries;

use Cardz\Generic\Identity\Application\Queries\GetToken;
use Cardz\Generic\Identity\Domain\Persistence\Contracts\UserRepositoryInterface;
use Cardz\Generic\Identity\Tests\Support\Builders\UserBuilder;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

class GetTokenQueryTest extends BaseTestCase
{
    use ApplicationTestTrait;

    public function test_token_can_be_obtained()
    {
        $userBuilder = UserBuilder::make();
        $user = $userBuilder->build();
        $this->getUserRepository()->persist($user);

        $query = GetToken::of($user->identity, $userBuilder->plainTextPassword, $userBuilder->faker()->word());
        $token = $this->queryBus()->execute($query);

        $this->assertNotEmpty($token);
        $this->assertMatchesRegularExpression('/\d+\|.{40}/', $token);
    }

    protected function getUserRepository(): UserRepositoryInterface
    {
        return $this->app->make(UserRepositoryInterface::class);
    }
}
