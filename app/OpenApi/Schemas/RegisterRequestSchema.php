<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class RegisterRequestSchema extends SchemaFactory implements Reusable
{
    use SchemaFakerTrait;

    /**
     * @return SchemaContract
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        $phone = Schema::string('phone')
            ->description('Phone')
            ->example($this->phone());

        $email = Schema::string('email')
            ->description('Email is required if phone is not provided')
            ->example($this->email());

        $name = Schema::string('name')
            ->description('Customer name')
            ->example($this->name());

        $password = Schema::string('password')
            ->format(Schema::FORMAT_PASSWORD)
            ->description('Password')
            ->example($this->password());

        $deviceName = Schema::string('deviceName')
            ->description('Device name is required to distinguish between different access tokens')
            ->example($this->word());

        $phoneRequired = Schema::object('Phone identity')
            ->description('Phone required')
            ->required($phone, $name, $password, $deviceName)
            ->properties($phone, $email, $name, $password, $deviceName);

        $emailRequired = Schema::object('Email identity')
            ->description('Email required')
            ->required($email, $name, $password, $deviceName)
            ->properties($phone, $email, $name, $password, $deviceName);

        return AnyOf::create('RegisterRequest')
            ->schemas($phoneRequired, $emailRequired);
    }

}
