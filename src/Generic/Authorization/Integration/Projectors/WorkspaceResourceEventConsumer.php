<?php

namespace Cardz\Generic\Authorization\Integration\Projectors;

use Cardz\Core\Workspaces\Integration\Events\NewWorkspaceRegistered;
use Cardz\Core\Workspaces\Integration\Events\WorkspaceChanged;
use Cardz\Generic\Authorization\Domain\Resource\Resource;
use Cardz\Generic\Authorization\Domain\Resource\ResourceRepositoryInterface;
use Cardz\Generic\Authorization\Integration\Mappers\WorkspaceEventToResourceMapper;

final class WorkspaceResourceEventConsumer extends BaseResourceEventConsumer
{
    public function __construct(
        ResourceRepositoryInterface $resourceRepository,
        WorkspaceEventToResourceMapper $mapper,
    ) {
        $this->resourceRepository = $resourceRepository;
        $this->mapper = $mapper;
    }

    public function consumes(): array
    {
        return [
            NewWorkspaceRegistered::class,
            WorkspaceChanged::class,
        ];
    }

    protected function augmentAttributes(Resource $resource): void
    {
    }

}
