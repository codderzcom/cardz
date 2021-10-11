<?php

namespace App\Contexts\Cards\Presentation\Controllers\Http\Card\Commands;

use App\Contexts\Cards\Application\Commands\IssueCard;
use App\Contexts\Cards\Application\Commands\IssueCardCommandInterface;
use Illuminate\Foundation\Http\FormRequest;

final class IssueCardRequest extends FormRequest
{
    //protected function failedValidation(Validator $validator)
    //{
    //    throw new \RuntimeException("Error");
    //}

    public string $customerId;

    public string $planId;

    public string $description;

    public function rules(): array
    {
        return [
            'planId' => 'required',
            'customerId' => 'required',
        ];
    }

    public function passedValidation(): void
    {
        $this->planId = $this->input('planId');
        $this->customerId = $this->input('customerId');
    }

    public function messages(): array
    {
        return [
            'planId.required' => 'planId required',
            'customerId.required' => 'customerId required',
        ];
    }

    public function toCommand(): IssueCardCommandInterface
    {
        return IssueCard::of($this->planId, $this->customerId);
    }
}
