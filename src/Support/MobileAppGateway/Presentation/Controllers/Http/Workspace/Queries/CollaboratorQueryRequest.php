<?php

namespace Cardz\Support\MobileAppGateway\Presentation\Controllers\Http\Workspace\Queries;

use Codderz\Platypus\Contracts\GenericIdInterface;
use Codderz\Platypus\Infrastructure\Support\GuidBasedImmutableId;
use Illuminate\Foundation\Http\FormRequest;

class CollaboratorQueryRequest extends FormRequest
{
    public GenericIdInterface $collaboratorId;

    public function rules(): array
    {
        return [
            'collaboratorId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'collaboratorId.required' => 'collaboratorId required',
        ];
    }

    public function passedValidation(): void
    {
        $this->collaboratorId = GuidBasedImmutableId::of($this->input('collaboratorId'));
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'collaboratorId' => $this->user()->id,
        ]);
    }

}
