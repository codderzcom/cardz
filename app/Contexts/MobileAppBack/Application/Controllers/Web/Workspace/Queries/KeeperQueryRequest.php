<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Queries;

use Illuminate\Foundation\Http\FormRequest;

class KeeperQueryRequest extends FormRequest
{
    public string $keeperId;

    public function rules(): array
    {
        return [
            'keeperId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'keeperId.required' => 'keeperId required',
        ];
    }

    public function passedValidation(): void
    {
        $this->keeperId = $this->input('keeperId');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'keeperId' => $this->route('keeperId'),
        ]);
    }

}
