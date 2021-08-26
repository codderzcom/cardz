<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Plan\Commands;

class ChangePlanDescriptionRequest extends BaseCommandRequest
{
    public string $description;

    public function passedValidation(): void
    {
        $this->description = $this->input('description') ?: 'Error';
    }

}
