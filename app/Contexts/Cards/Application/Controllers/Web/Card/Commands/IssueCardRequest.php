<?php

namespace App\Contexts\Cards\Application\Controllers\Web\Card\Commands;

use Illuminate\Foundation\Http\FormRequest;

class IssueCardRequest extends FormRequest
{
    //protected function failedValidation(Validator $validator)
    //{
    //    throw new \RuntimeException("Error");
    //}

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
