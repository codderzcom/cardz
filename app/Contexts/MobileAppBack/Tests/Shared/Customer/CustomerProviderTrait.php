<?php

namespace App\Contexts\MobileAppBack\Tests\Shared\Customer;

trait CustomerProviderTrait
{
    public function getCustomer(string $populateWith = 'customer'): CustomerRequestDTO
    {
        return new CustomerRequestDTO($populateWith, $populateWith, $populateWith, $populateWith, $populateWith);
    }

    public function getAnotherCustomer(): CustomerRequestDTO
    {
        return $this->getCustomer('another');
    }

    public function getKeeper(): CustomerRequestDTO
    {
        return $this->getCustomer('keeper');
    }
}
