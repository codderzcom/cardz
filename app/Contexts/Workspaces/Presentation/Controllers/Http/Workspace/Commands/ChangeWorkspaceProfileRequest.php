<?php

namespace App\Contexts\Workspaces\Presentation\Controllers\Http\Workspace\Commands;

use App\Contexts\Workspaces\Application\Commands\ChangeWorkspaceProfile;
use App\Contexts\Workspaces\Domain\Model\Workspace\Profile;
use App\Contexts\Workspaces\Domain\Model\Workspace\WorkspaceId;
use Illuminate\Foundation\Http\FormRequest;

class ChangeWorkspaceProfileRequest extends FormRequest
{
    private string $workspaceId;

    private string $name;

    private string $description;

    private string $address;

    public function rules(): array
    {
        return [
            'workspaceId' => 'required',
            'name' => 'required',
            'description' => 'required',
            'address' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'workspaceId.required' => 'workspaceId required',
            'name.required' => 'name required',
            'description.required' => 'description required',
            'address.required' => 'address required',
        ];
    }

    public function passedValidation(): void
    {
        $this->workspaceId = $this->input('workspaceId');
        $this->name = $this->input('name');
        $this->description = $this->input('description');
        $this->address = $this->input('address');
    }

    public function getWorkspaceId(): WorkspaceId
    {
        return WorkspaceId::of($this->workspaceId);
    }

    public function toCommand(): ChangeWorkspaceProfile
    {
        return ChangeWorkspaceProfile::of($this->workspaceId, $this->name, $this->description, $this->address);
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'workspaceId' => $this->route('workspaceId'),
        ]);
    }
}
