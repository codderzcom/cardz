<?php

namespace Cardz\Generic\Authorization\Tests\Feature;

use Cardz\Generic\Authorization\Domain\Attribute\Attribute;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Cardz\Generic\Authorization\Infrastructure\ResourceProviderInterface;
use Cardz\Generic\Authorization\Tests\Support\Builders\ResourceBuilder;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

class ResourceTest extends BaseTestCase
{
    use AuthTestHelperTrait;

    public function test_resource_attributes_can_be_used()
    {
        $workspaceId = GuidBasedImmutableId::makeValue();
        $keeperId = GuidBasedImmutableId::makeValue();
        $collaboratorId = GuidBasedImmutableId::makeValue();
        $resource = ResourceBuilder::make()->buildWorkspace($workspaceId, $keeperId);
        $resource->appendAttributes([Attribute::MEMBER_IDS => [$keeperId, $collaboratorId]]);

        $this->getResourceRepository()->persist($resource);

        $resource = $this->getResourceRepository()->find($resource->resourceId, $resource->resourceType);

        $this->assertEquals($workspaceId, $resource(Attribute::WORKSPACE_ID));
        $this->assertTrue($resource->attr(Attribute::MEMBER_IDS)->contains($collaboratorId, $keeperId));
    }

    public function test_collaborative_resource_can_be_reconstructed()
    {
        $workspaceId = GuidBasedImmutableId::makeValue();
        $keeperId = GuidBasedImmutableId::makeValue();
        $collaboratorId = GuidBasedImmutableId::makeValue();

        $this->getResourceRepository()->persist(ResourceBuilder::make()->buildWorkspace($workspaceId, $keeperId));
        $this->getResourceRepository()->persist(ResourceBuilder::make()->buildRelation($keeperId, $workspaceId, 'keeper'));
        $this->getResourceRepository()->persist(ResourceBuilder::make()->buildRelation($collaboratorId, $workspaceId, 'member'));

        /** @var ResourceProviderInterface $provider */
        $provider = $this->app->make(ResourceProviderInterface::class);
        $attributes = $provider->getResourceAttributes(GuidBasedImmutableId::of($workspaceId), ResourceType::WORKSPACE());
        $this->assertTrue($attributes(Attribute::MEMBER_IDS)->contains($collaboratorId, $keeperId));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->setupApplication();
    }

}
