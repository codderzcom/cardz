<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Plan\Commands;

use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use App\Contexts\Plans\Domain\Model\Shared\WorkspaceId;

class AddPlanRequest extends BaseCommandRequest
{
    public WorkspaceId $workspaceId;

    public ?string $description;

    protected function inferPlanId(): void
    {
        $this->planId = new PlanId();
    }

    public function passedValidation(): void
    {
        $this->workspaceId = new WorkspaceId($this->input('workspaceId'));
        $this->description = $this->input('description');
    }

    public function messages()
    {
        return [
            'description.required' => 'description required',
        ];
    }
}
