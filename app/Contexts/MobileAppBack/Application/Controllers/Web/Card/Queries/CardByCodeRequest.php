<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Card\Queries;

use App\Contexts\MobileAppBack\Domain\Card\CardId;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CardByCodeRequest extends FormRequest
{
    public string $code;

    public function rules(): array
    {
        return [
            'code' => 'required'
        ];
    }

    public function passedValidation(): void
    {
        $this->code = $this->input('code');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'code' => $this->route('code'),
        ]);
    }

}
