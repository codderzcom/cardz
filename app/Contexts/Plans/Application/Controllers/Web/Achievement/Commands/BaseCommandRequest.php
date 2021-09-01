<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Achievement\Commands;

use App\Contexts\Plans\Domain\Model\Achievement\AchievementId;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseCommandRequest extends FormRequest
{
    public AchievementId $achievementId;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    public function rules()
    {
        return [
            //'achievementId' => 'required'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->inferAchievementId();
    }

    protected function inferAchievementId(): void
    {
        $this->achievementId = AchievementId::of($this->route('achievementId'));
    }
}
