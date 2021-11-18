<?php

namespace App\Contexts\Collaboration\Tests\Feature\Application\Commands\Invite;

use App\Contexts\Collaboration\Application\Commands\Invite\AcceptInvite;
use App\Contexts\Collaboration\Domain\Events\Invite\InviteAccepted;
use App\Contexts\Collaboration\Domain\Exceptions\CannotAcceptOwnInviteException;
use App\Contexts\Collaboration\Domain\Model\Relation\CollaboratorId;
use App\Contexts\Collaboration\Tests\Feature\CollaborationTestHelperTrait;
use App\Contexts\Collaboration\Tests\Support\Builders\InviteBuilder;
use App\Shared\Infrastructure\Tests\ApplicationTestTrait;
use App\Shared\Infrastructure\Tests\BaseTestCase;

class AcceptInviteComandTest extends BaseTestCase
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
