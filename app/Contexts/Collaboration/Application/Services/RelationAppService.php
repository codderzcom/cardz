<?php

namespace App\Contexts\Collaboration\Application\Services;

use App\Contexts\Collaboration\Application\Contracts\RelationRepositoryInterface;
use App\Contexts\Collaboration\Application\IntegrationEvents\RelationLeft;
use App\Contexts\Collaboration\Application\Services\Policies\AssertLeavingMemberIsNotKeeper;
use App\Contexts\Collaboration\Domain\Model\Relation\RelationId;
use App\Shared\Contracts\PolicyEngineInterface;
use App\Shared\Contracts\ReportingBusInterface;
use App\Shared\Contracts\ServiceResultFactoryInterface;
use App\Shared\Contracts\ServiceResultInterface;
use App\Shared\Infrastructure\Support\ReportingServiceTrait;

class RelationAppService
{
    use ReportingServiceTrait;

    public function __construct(
        private RelationRepositoryInterface $relationRepository,
        private ReportingBusInterface $reportingBus,
        private PolicyEngineInterface $policyEngine,
        private ServiceResultFactoryInterface $serviceResultFactory,
    ) {
    }

    public function leave(string $relationId): ServiceResultInterface
    {
        return $this->policyEngine->passTrough(
            function () use ($relationId) {
                $relation = $this->relationRepository->take(RelationId::of($relationId));
                if ($relation === null) {
                    return $this->serviceResultFactory->notFound("Relation $relationId not found");
                }
                $relation->leave();
                $this->relationRepository->persist($relation);

                $result = $this->serviceResultFactory->ok($relation->relationId, new RelationLeft($relation->relationId));
                return $this->reportResult($result, $this->reportingBus);
            },
            AssertLeavingMemberIsNotKeeper::of(RelationId::of($relationId)),
        );
    }
}
