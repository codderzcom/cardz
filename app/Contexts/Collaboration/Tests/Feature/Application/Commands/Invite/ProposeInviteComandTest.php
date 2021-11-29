<?php

namespace App\Contexts\Collaboration\Tests\Feature\Application\Commands\Invite;

use App\Contexts\Collaboration\Application\Commands\Invite\ProposeInvite;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteProposed;
use App\Contexts\Collaboration\Domain\Model\Workspace\KeeperId;
use App\Contexts\Collaboration\Domain\Model\Workspace\WorkspaceId;
use App\Contexts\Collaboration\Tests\Feature\CollaborationTestHelperTrait;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

class ProposeInviteComandTest extends BaseTestCase
{
    use ApplicationTestTrait, CollaborationTestHelperTrait;

    public function test_invite_can_be_proposed()
    {
        $command = ProposeInvite::of(KeeperId::makeValue(), WorkspaceId::makeValue());
        $this->commandBus()->dispatch($command);

        $invite = $this->getInviteRepository()->take($command->getInviteId());

        $this->assertEquals($command->getInviteId(), $invite->inviteId);
        $this->assertEvent(InviteProposed::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }
}
