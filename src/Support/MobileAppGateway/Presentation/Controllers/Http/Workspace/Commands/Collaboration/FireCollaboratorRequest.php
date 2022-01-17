<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\Collaboration;

use Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Commands\BaseCommandRequest;

class FireCollaboratorRequest extends BaseCommandRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'workspaceId' => $this->route('workspaceId'),
            'collaboratorId' => $this->route('collaboratorId'),
        ]);
    }

}
