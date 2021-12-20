<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Collaboration;

use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\BaseCommandRequest;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;

class FireCollaboratorRequest extends BaseCommandRequest
{
    public function passedValidation(): void
    {
        $this->workspaceId = GuidBasedImmutableId::of($this->input('workspaceId'));
        $this->collaboratorId = GuidBasedImmutableId::of($this->input('collaboratorId'));
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'workspaceId' => $this->route('workspaceId'),
            'collaboratorId' => $this->route('collaboratorId'),
        ]);
    }

}
