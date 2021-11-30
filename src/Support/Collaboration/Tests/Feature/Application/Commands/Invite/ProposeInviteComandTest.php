<?php

namespace Cardz\Support\Collaboration\Tests\Feature\Application\Commands\Invite;

use Cardz\Support\Collaboration\Application\Commands\Invite\ProposeInvite;
use Cardz\Support\Collaboration\Domain\Events\Invite\InviteProposed;
use Cardz\Support\Collaboration\Domain\Model\Workspace\KeeperId;
use Cardz\Support\Collaboration\Domain\Model\Workspace\WorkspaceId;
use Cardz\Support\Collaboration\Tests\Feature\CollaborationTestHelperTrait;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

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
