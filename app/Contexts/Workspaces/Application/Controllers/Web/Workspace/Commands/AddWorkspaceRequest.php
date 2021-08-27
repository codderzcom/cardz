<?php

namespace App\Contexts\Workspaces\Application\Controllers\Web\Workspace\Commands;

use App\Contexts\Workspaces\Domain\Model\Workspace\Profile;
use App\Contexts\Workspaces\Domain\Model\Workspace\WorkspaceId;

class AddWorkspaceRequest extends BaseCommandRequest
{
    public WorkspaceId $workspaceId;

    public Profile $profile;

    public function passedValidation(): void
    {
        $this->profile = Profile::create(
            $this->input('name'),
            $this->input('description'),
            $this->input('address'),
        );
    }

    public function messages()
    {
        return [
            'name.required' => 'name required',
            'description.required' => 'description required',
            'address.required' => 'address required',
        ];
    }

    protected function inferWorkspaceId(): void
    {
        $this->workspaceId = new WorkspaceId();
    }
}
