<?php

namespace App\Contexts\Personal\Presentation\Controllers\Http\Person\Commands;

use App\Contexts\Personal\Application\Commands\ChangePersonName;
use App\Contexts\Personal\Application\Commands\ChangePersonNameCommandInterface;
use Illuminate\Foundation\Http\FormRequest;

final class ChangePersonNameRequest extends FormRequest
{
    public string $personId;

    public string $name;

    public function rules(): array
    {
        return [
            'personId' => 'required',
            'name' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'personId.required' => 'personId required',
            'name.required' => 'name required',
        ];
    }

    public function passedValidation(): void
    {
        $this->personId = $this->input('personId');
        $this->name = $this->input('name');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'personId' => $this->route('personId'),
        ]);
    }

    public function toCommand(): ChangePersonNameCommandInterface
    {
        return ChangePersonName::of($this->personId, $this->name);
    }
}
