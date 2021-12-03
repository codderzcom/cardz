<?php

namespace Cardz\Generic\Authorization\Tests\Feature;

use Cardz\Core\Cards\Domain\Persistence\Contracts\CardRepositoryInterface;
use Cardz\Core\Cards\Tests\Support\Builders\CardBuilder;
use Cardz\Core\Cards\Tests\Support\Mocks\CardInMemoryRepository;
use Cardz\Core\Plans\Domain\Persistence\Contracts\PlanRepositoryInterface;
use Cardz\Core\Plans\Domain\Persistence\Contracts\RequirementRepositoryInterface;
use Cardz\Core\Plans\Tests\Support\Builders\PlanBuilder;
use Cardz\Core\Plans\Tests\Support\Mocks\PlanInMemoryRepository;
use Cardz\Core\Plans\Tests\Support\Mocks\RequirementInMemoryRepository;
use Cardz\Core\Workspaces\Domain\Persistence\Contracts\WorkspaceRepositoryInterface;
use Cardz\Core\Workspaces\Tests\Support\Builders\WorkspaceBuilder;
use Cardz\Core\Workspaces\Tests\Support\Mocks\WorkspaceInMemoryRepository;
use Cardz\Generic\Authorization\Application\AuthorizationBusInterface;
use Cardz\Generic\Authorization\Application\Queries\IsAllowed;
use Cardz\Generic\Authorization\Domain\Permissions\AuthorizationPermission;
use Cardz\Generic\Authorization\Domain\Resource\Resource;
use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Cardz\Generic\Authorization\Tests\Support\Builders\ResourceBuilder;
use Cardz\Generic\Authorization\Tests\Support\Mocks\ResourceInMemoryRepository;
use Cardz\Generic\Identity\Domain\Persistence\Contracts\UserRepositoryInterface;
use Cardz\Generic\Identity\Tests\Support\Builders\UserBuilder;
use Cardz\Generic\Identity\Tests\Support\Mocks\UserInMemoryRepository;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\InviteRepositoryInterface;
use Cardz\Support\Collaboration\Domain\Persistence\Contracts\RelationRepositoryInterface;
use Cardz\Support\Collaboration\Tests\Support\Builders\InviteBuilder;
use Cardz\Support\Collaboration\Tests\Support\Builders\RelationBuilder;
use Cardz\Support\Collaboration\Tests\Support\Mocks\InviteInMemoryRepository;
use Cardz\Support\Collaboration\Tests\Support\Mocks\RelationInMemoryRepository;
use Codderz\Platypus\Contracts\GeneralIdInterface;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;

trait AuthTestHelperTrait
{
    protected GeneralIdInterface $keeperId;

    protected GeneralIdInterface $collaboratorId;

    protected GeneralIdInterface $strangerId;

    protected GeneralIdInterface $workspaceId;

    protected GeneralIdInterface $planId;

    protected GeneralIdInterface $cardId;

    protected GeneralIdInterface $inviteId;

    protected function setupApplication(): void
    {
        $this->app->singleton(ResourceRepositoryInterface::class, ResourceInMemoryRepository::class);
    }

    protected function getResourceRepository(): ResourceRepositoryInterface
    {
        return $this->app->make(ResourceRepositoryInterface::class);
    }

    protected function authorizationBus(): AuthorizationBusInterface
    {
        return $this->app->make(AuthorizationBusInterface::class);
    }

    protected function assertGranted(AuthorizationPermission $permission, GeneralIdInterface $subjectId, GeneralIdInterface $objectId): void
    {
        $result = $this->authorizationBus()->execute(IsAllowed::of($permission, $subjectId, $objectId));
        $this->assertTrue($result, "Permission $permission should be granted");
    }

    protected function assertDenied(AuthorizationPermission $permission, GeneralIdInterface $subjectId, GeneralIdInterface $objectId): void
    {
        $result = $this->authorizationBus()->execute(IsAllowed::of($permission, $subjectId, $objectId));
        $this->assertFalse($result, "Permission $permission should be denied");
    }

    protected function setupEnvironment(): void
    {
        $builder = ResourceBuilder::make();
        $this->keeperId = GuidBasedImmutableId::make();
        $this->collaboratorId = GuidBasedImmutableId::make();
        $this->strangerId = GuidBasedImmutableId::make();
        $this->workspaceId = GuidBasedImmutableId::make();
        $this->planId = GuidBasedImmutableId::make();
        $this->cardId = GuidBasedImmutableId::make();
        $this->inviteId = GuidBasedImmutableId::make();

        $this->getResourceRepository()->persist($builder->buildSubject($this->keeperId));
        $this->getResourceRepository()->persist($builder->buildSubject($this->collaboratorId));
        $this->getResourceRepository()->persist($builder->buildSubject($this->strangerId));
        $this->getResourceRepository()->persist($builder->buildWorkspace($this->workspaceId, $this->keeperId));
        $this->getResourceRepository()->persist($builder->buildPlan($this->planId, $this->workspaceId, $this->keeperId));
        $this->getResourceRepository()->persist($builder->buildCard($this->cardId, $this->strangerId, $this->planId, $this->workspaceId, $this->keeperId));

        $this->getResourceRepository()->persist($builder->buildRelation($this->keeperId, $this->workspaceId, 'keeper'));
        $this->getResourceRepository()->persist($builder->buildRelation($this->collaboratorId, $this->workspaceId, 'member'));
    }

}
