<?php

namespace App\Contexts\Cards\Application\Controllers\Web\Card\Commands;

use App\Contexts\Cards\Domain\Model\Card\CardId;
use App\Contexts\Cards\Domain\Model\Shared\BonusProgramId;
use App\Contexts\Cards\Domain\Model\Shared\CustomerId;

class IssueCardRequest extends BaseCommandRequest
{
    public CustomerId $customerId;

    public BonusProgramId $bonusProgramId;

    public ?string $description;

    protected function inferCardId(): void
    {
        $this->cardId = new CardId();
    }

    public function passedValidation(): void
    {
        $this->bonusProgramId = new BonusProgramId($this->input('bonusProgramId'));
        $this->customerId = new CustomerId($this->input('customerId'));
        $this->description = $this->input('description');
    }

    public function messages()
    {
        return [
            'bonusProgramId.required' => 'bonusProgramId required',
            'customerId.required' => 'customerId required',
        ];
    }
}
