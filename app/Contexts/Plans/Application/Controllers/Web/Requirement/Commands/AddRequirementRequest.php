<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Requirement\Commands;

use Illuminate\Foundation\Http\FormRequest;

final class AddRequirementRequest extends FormRequest
{
    public string $planId;

    public string $description;

    public function rules(): array
    {
        return [
            'planId' => 'required',
            'description' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'planId.required' => 'planId required',
            'description.required' => 'description required',
        ];
    }

    public function passedValidation(): void
    {
        $this->planId = $this->input('planId');
        $this->description = $this->input('description');
    }

}
