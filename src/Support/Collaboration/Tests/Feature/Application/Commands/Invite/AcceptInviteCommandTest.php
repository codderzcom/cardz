<?php

namespace Cardz\Support\Collaboration\Tests\Feature\Application\Commands\Invite;

use Cardz\Support\Collaboration\Application\Commands\Invite\AcceptInvite;
use Cardz\Support\Collaboration\Domain\Events\Invite\InviteAccepted;
use Cardz\Support\Collaboration\Domain\Exceptions\CannotAcceptOwnInviteException;
use Cardz\Support\Collaboration\Domain\Model\Relation\CollaboratorId;
use Cardz\Support\Collaboration\Tests\Feature\CollaborationTestHelperTrait;
use Cardz\Support\Collaboration\Tests\Support\Builders\InviteBuilder;
use Codderz\Platypus\Infrastructure\Tests\ApplicationTestTrait;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

class AcceptInviteCommandTest extends BaseTestCase
{
    use ApplicationTestTrait, CollaborationTestHelperTrait;

    public function test_invite_can_be_accepted()
    {
        $invite = InviteBuilder::make()->build();
        $this->getInviteRepository()->persist($invite);

        $command = AcceptInvite::of($invite->inviteId, CollaboratorId::make());
        $this->commandBus()->dispatch($command);

        $this->assertTrue($invite->isAccepted());
        $this->assertEvent(InviteAccepted::class);
    }

    public function test_invite_cannot_be_accepted_by_keeper()
    {
        $invite = InviteBuilder::make()->build();
        $this->getInviteRepository()->persist($invite);

        $command = AcceptInvite::of($invite->inviteId, $invite->inviterId);

        $this->expectException(CannotAcceptOwnInviteException::class);
        $this->commandBus()->dispatch($command);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }
}
