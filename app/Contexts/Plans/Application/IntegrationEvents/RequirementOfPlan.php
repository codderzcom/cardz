<?php

namespace App\Contexts\Plans\Application\IntegrationEvents;

use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

#[Immutable]
class RequirementOfPlan extends BaseIntegrationEvent
{
    protected string $in = 'Plans';

    protected string $of = 'Requirement';

    #[Pure]
    public function __construct(
        string $id,
        protected string $planId,
    ) {
        parent::__construct($id);
        $this->id = $id;
    }

    public function getPlanId(): string
    {
        return $this->planId;
    }

    public function payload(): array
    {
        return [
            'planId' => $this->planId,
        ];
    }

}
