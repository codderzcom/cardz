<?php

namespace App\Contexts\Workspaces\Application\Controllers\Web\Workspace\Commands;

use App\Contexts\Workspaces\Domain\Model\Workspace\Profile;

class ChangeWorkspaceProfileRequest extends BaseCommandRequest
{
    public Profile $profile;

    public function passedValidation(): void
    {
        $this->profile = Profile::fromData([
            'name' => $this->input('name'),
            'description' => $this->input('description'),
            'address' => $this->input('address'),
        ]);
    }

}
