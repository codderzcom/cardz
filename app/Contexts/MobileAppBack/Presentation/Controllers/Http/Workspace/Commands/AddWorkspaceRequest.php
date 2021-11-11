<?php

namespace App\Contexts\MobileAppBack\Presentation\Controllers\Http\Workspace\Commands;

use App\Shared\Contracts\GeneralIdInterface;
use App\Shared\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Foundation\Http\FormRequest;

final class AddWorkspaceRequest extends FormRequest
{
    public GeneralIdInterface $keeperId;

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

    public function messages(): array
    {
        return [
            'keeperId.required' => 'keeperId required',
            'name.required' => 'name required',
            'description.required' => 'description required',
            'address.required' => 'address required',
        ];
    }

    public function passedValidation(): void
    {
        $this->keeperId = GuidBasedImmutableId::of($this->input('keeperId'));
        $this->name = $this->input('name');
        $this->description = $this->input('description');
        $this->address = $this->input('address');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'keeperId' => $this->user()->id,
        ]);
    }
}
