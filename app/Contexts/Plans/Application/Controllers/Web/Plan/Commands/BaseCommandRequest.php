<?php

namespace App\Contexts\Plans\Application\Controllers\Web\Plan\Commands;

use App\Contexts\Plans\Domain\Model\Plan\PlanId;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseCommandRequest extends FormRequest
{
    public PlanId $planId;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    public function rules()
    {
        return [
            //'planId' => 'required'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->inferPlanId();
    }

    protected function inferPlanId(): void
    {
        $this->planId = PlanId::of($this->route('planId'));
    }
}
