<?php

namespace App\Contexts\Workspaces\Presentation\Controllers\Http\Workspace\Commands;

use Illuminate\Foundation\Http\FormRequest;

class AddWorkspaceRequest extends FormRequest
{
    public string $keeperId;

    public string $name;

    public string $description;

    public string $address;

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
}
