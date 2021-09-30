<?php

namespace App\Contexts\Workspaces\Presentation\Controllers\Http\Workspace\Commands;

use App\Contexts\Workspaces\Application\Commands\AddWorkspaceCommandInterface;
use App\Contexts\Workspaces\Domain\Model\Workspace\KeeperId;
use App\Contexts\Workspaces\Domain\Model\Workspace\Profile;
use App\Contexts\Workspaces\Domain\Model\Workspace\WorkspaceId;
use Illuminate\Foundation\Http\FormRequest;

class AddWorkspaceRequest extends FormRequest implements AddWorkspaceCommandInterface
{
    private string $keeperId;

    private string $name;

    private string $description;

    private string $address;

    public function rules(): array
    {
        return [
            'keeperId' => 'required',
            'name' => 'required',
            'description' => 'required',
            'address' => 'required',
        ];
    }

    public function passedValidation(): void
    {
        $this->keeperId = $this->input('keeperId');
        $this->name = $this->input('name');
        $this->description = $this->input('description');
        $this->address = $this->input('address');
        $this->workspaceId = (string) WorkspaceId::make();
    }

    public function messages(): array
    {
        return [
            'keeperId.required' => 'keeperId required',
            'name.required' => 'name required',
            'description.required' => 'description required',
            'address.required' => 'address required',
        ];
    }

    public function getKeeperId(): KeeperId
    {
        return KeeperId::of($this->keeperId);
    }

    public function getWorkspaceId(): WorkspaceId
    {
        return WorkspaceId::of($this->workspaceId);
    }

    public function getProfile(): Profile
    {
        return Profile::of($this->name, $this->description, $this->address);
    }

}
