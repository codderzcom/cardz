<?php

namespace App\Contexts\MobileAppBack\Tests\Shared;

trait CustomerProviderTrait
{
    public function getCustomer(string $populateWith = 'customer'): CustomerDTO
    {
        return new CustomerDTO($populateWith, $populateWith, $populateWith, $populateWith, $populateWith);
    }

    public function getAnotherCustomer(): CustomerDTO
    {
        return $this->getCustomer('another');
    }

    public function getKeeper(): CustomerDTO
    {
        return $this->getCustomer('keeper');
    }
}
