<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class GetTokenRequestSchema extends SchemaFactory implements Reusable
{
    use SchemaFakerTrait;

    /**
     * @return SchemaContract
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        $identity = Schema::string('identity')
            ->description('Identity is either phone or email')
            ->example($this->email());

        $password = Schema::string('password')
            ->format(Schema::FORMAT_PASSWORD)
            ->description('Password')
            ->example($this->password());

        $deviceName = Schema::string('deviceName')
            ->description('Device name is required to distinguish between different access tokens')
            ->example($this->word());

        return Schema::object('GetTokenRequest')
            ->description('New API access token for the specific device request')
            ->required($identity, $password, $deviceName)
            ->properties($identity, $password, $deviceName);
    }

}
