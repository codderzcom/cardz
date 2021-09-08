<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Plan\Commands;

use Illuminate\Foundation\Http\FormRequest;

final class AddPlanRequest extends FormRequest
{
    public string $workspaceId;

    public string $description;

    public function rules(): array
    {
        return [
            'workspaceId' => 'required',
            'description' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'workspaceId.required' => 'workspaceId required',
            'description.required' => 'description required',
        ];
    }

    public function passedValidation(): void
    {
        $this->workspaceId = $this->input('workspaceId');
        $this->description = $this->input('description');
    }

}
