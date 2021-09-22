<?php

namespace App\Contexts\MobileAppBack\Application\Controllers\Web\Workspace\Queries;

class CardByCodeRequest extends BaseWorkspaceQueryRequest
{
    protected const RULES = [
        'code' => 'required',
    ];

    protected const MESSAGES = [
        'code.required' => 'code required',
    ];

    public string $code;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->code = $this->input('code');
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $this->merge([
            'code' => $this->route('code'),
        ]);
    }

}
