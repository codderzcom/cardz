<?php

namespace Cardz\Generic\Authorization\Tests\Feature;

use Cardz\Generic\Authorization\Application\AuthorizationBusInterface;
use Cardz\Generic\Authorization\Application\Queries\IsAllowed;
use Cardz\Generic\Authorization\Domain\Permissions\AuthorizationPermission;
use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Authorization\Tests\Support\Builders\ResourceBuilder;
use Cardz\Generic\Authorization\Tests\Support\Mocks\ResourceInMemoryRepository;
use Codderz\Platypus\Contracts\GenericIdInterface;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;

trait AuthTestHelperTrait
{
    protected GenericIdInterface $keeperId;

    protected GenericIdInterface $collaboratorId;

    protected GenericIdInterface $strangerId;

    protected GenericIdInterface $workspaceId;

    protected GenericIdInterface $planId;

    protected GenericIdInterface $cardId;

    protected GenericIdInterface $inviteId;

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

    protected function assertGranted(AuthorizationPermission $permission, GenericIdInterface $subjectId, GenericIdInterface $objectId): void
    {
        $result = $this->authorizationBus()->execute(IsAllowed::of($permission, $subjectId, $objectId));
        $this->assertTrue($result, "Permission $permission should be granted");
    }

    protected function assertDenied(AuthorizationPermission $permission, GenericIdInterface $subjectId, GenericIdInterface $objectId): void
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
