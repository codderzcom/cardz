<?php

namespace App\Contexts\Personal\Application\Controllers\Web\Person\Commands;

final class JoinPersonRequest extends BaseCommandRequest
{
    protected const RULES = [
        'name' => 'required',
    ];

    protected const MESSAGES = [
        'name.required' => 'name required',
    ];

    public string $name;

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->name = $this->input('name');
    }

}
