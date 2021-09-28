<?php

namespace App\Contexts\Workspaces\Presentation\Controllers\Http\Workspace\Commands;

class ChangeWorkspaceProfileRequest extends BaseCommandRequest
{
    protected const RULES = [
        'name' => 'required',
        'description' => 'required',
        'address' => 'required',
    ];

    protected const MESSAGES = [
        'name.required' => 'name required',
        'description.required' => 'description required',
        'address.required' => 'address required',
    ];

    public string $name;

    public string $description;

    public string $address;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->name = $this->input('name');
        $this->description = $this->input('description');
        $this->address = $this->input('address');
    }

}
