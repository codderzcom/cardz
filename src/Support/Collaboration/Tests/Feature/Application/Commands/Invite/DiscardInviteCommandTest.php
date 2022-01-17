<?php

namespace Cardz\Support\Collaboration\Tests\Feature\Application\Commands\Invite;

use Cardz\Support\Collaboration\Application\Commands\Invite\DiscardInvite;
use Cardz\Support\Collaboration\Domain\Events\Invite\InviteDiscarded;
use Cardz\Support\Collaboration\Tests\Feature\CollaborationTestHelperTrait;
use Cardz\Support\Collaboration\Tests\Support\Builders\InviteBuilder;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

class DiscardInviteCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, CollaborationTestHelperTrait;

    public function test_invite_can_be_discarded()
    {
        $invite = InviteBuilder::make()->build();
        $this->getInviteRepository()->persist($invite);

        $command = DiscardInvite::of($invite->inviteId);
        $this->commandBus()->dispatch($command);

        $this->assertTrue($invite->isDiscarded());
        $this->assertEvent(InviteDiscarded::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }
}
