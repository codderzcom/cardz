<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Plan\Commands;

final class ChangeRequirementsRequest extends BaseCommandRequest
{
    protected const RULES = [
        'descriptions' => 'required',
    ];

    protected const MESSAGES = [
        'descriptions.required' => 'descriptions required',
    ];

    /**
     * @var string[]
     */
    public array $descriptions = [];

    public function passedValidation(): void
    {
        parent::passedValidation();
        $this->descriptions = $this->input('descriptions');
    }
}
