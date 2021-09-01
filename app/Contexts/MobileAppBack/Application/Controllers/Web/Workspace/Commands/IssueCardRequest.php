<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Commands;

use Illuminate\Foundation\Http\FormRequest;

class IssueCardRequest extends FormRequest
{
    public string $customerId;

    public string $planId;

    public string $description;

    public function rules(): array
    {
        return [
            'planId' => 'required',
            'customerId' => 'required',
            'description' => 'required',
        ];
    }

    public function passedValidation(): void
    {
        $this->planId = $this->input('planId');
        $this->customerId = $this->input('customerId');
        $this->description = $this->input('description');
    }

    public function messages(): array
    {
        return [
            'planId.required' => 'planId required',
            'customerId.required' => 'customerId required',
            'description.required' => 'description required',
        ];
    }
}
