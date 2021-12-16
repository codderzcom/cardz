<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class GetTokenRequestSchema extends SchemaFactory implements Reusable
{
    /**
     * @return SchemaContract
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        $identity = Schema::string('identity')->description('Identity is either phone or email');
        $password = Schema::string('password')->format(Schema::FORMAT_PASSWORD)->description('Password');
        $deviceName = Schema::string('deviceName')->description('Device name is required to distinguish between different access tokens');

        return Schema::object('GetTokenRequest')
            ->description('New API access token for the specific device request')
            ->required($identity, $password, $deviceName)
            ->properties($identity, $password, $deviceName);
    }

}
