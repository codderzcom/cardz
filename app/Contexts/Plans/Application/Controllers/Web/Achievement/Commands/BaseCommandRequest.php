<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Achievement\Commands;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseCommandRequest extends FormRequest
{
    protected const RULES = [
        'achievementId' => 'required',
    ];

    protected const MESSAGES = [
        'achievementId.required' => 'achievementId required',
    ];

    public string $achievementId;

    public function rules(): array
    {
        return array_merge(self::RULES, static::RULES);
    }

    public function messages(): array
    {
        return array_merge(self::MESSAGES, static::MESSAGES);
    }

    public function passedValidation(): void
    {
        $this->achievementId = $this->input('achievementId');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'achievementId' => $this->route('achievementId'),
        ]);
    }

}
