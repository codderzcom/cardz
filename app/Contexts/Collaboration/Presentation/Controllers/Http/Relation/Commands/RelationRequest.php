<?php

namespace App\Contexts\Collaboration\Presentation\Controllers\Http\Relation\Commands;

use App\Contexts\Collaboration\Application\Commands\Relation\LeaveRelation;
use App\Contexts\Collaboration\Application\Commands\Relation\LeaveRelationCommandInterface;
use Illuminate\Foundation\Http\FormRequest;

final class RelationRequest extends FormRequest
{
    public string $relationId;

    public function rules(): array
    {
        return [
            'relationId' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'relationId.required' => 'relationId required',
        ];
    }

    public function passedValidation(): void
    {
        $this->relationId = $this->input('relationId');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'relationId' => $this->route('relationId'),
        ]);
    }

    public function toCommand(): LeaveRelationCommandInterface
    {
        return LeaveRelation::of($this->relationId);
    }
}
