<?php

namespace App\Contexts\Plans\Presentation\Controllers\Http\Requirement\Commands;

use App\Contexts\Plans\Application\Commands\Requirement\AddRequirement;
use App\Contexts\Plans\Application\Commands\Requirement\AddRequirementCommandInterface;
use Illuminate\Foundation\Http\FormRequest;

final class AddRequirementRequest extends FormRequest
{
    private string $planId;

    private string $description;

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

    protected function prepareForValidation(): void
    {
        $this->merge([
            'planId' => $this->route('planId'),
        ]);
    }

    public function toCommand(): AddRequirementCommandInterface
    {
        return AddRequirement::of($this->planId, $this->description);
    }

}
