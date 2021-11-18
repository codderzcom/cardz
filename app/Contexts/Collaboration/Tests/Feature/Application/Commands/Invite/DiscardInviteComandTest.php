<?php

namespace App\Contexts\Collaboration\Tests\Feature\Application\Commands\Invite;

use App\Contexts\Collaboration\Application\Commands\Invite\DiscardInvite;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteDiscarded;
use App\Contexts\Collaboration\Tests\Feature\CollaborationTestHelperTrait;
use App\Contexts\Collaboration\Tests\Support\Builders\InviteBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

class DiscardInviteComandTest extends BaseTestCase
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
