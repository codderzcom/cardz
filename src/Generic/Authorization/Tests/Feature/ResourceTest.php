<?php

namespace Cardz\Generic\Authorization\Tests\Feature;

use Cardz\Generic\Authorization\Domain\Resource\Resource;
use Cardz\Generic\Authorization\Domain\Resource\ResourceId;
use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Authorization\Domain\Resource\ResourceType;
use Codderz\Platypus\Infrastructure\Tests\BaseTestCase;

class ResourceTest extends BaseTestCase
{
    public function test_resource()
    {
        /** @var ResourceRepositoryInterface $repo */
        $repo = $this->app->make(ResourceRepositoryInterface::class);
        $id = ResourceId::makeValue();
        $resource = Resource::restore($id, ResourceType::WORKSPACE, [
            'workspaceId' => $id,
        ]);
        $resource->appendAttributes(['memberIds' => [1, 2, 3]]);
        $repo->persist($resource);
        $resource = $repo->find($resource->resourceId, $resource->resourceType);
        $this->assertCount(2, $resource->attributes);
        $this->assertCount(3, $resource->memberIds);
    }
}
