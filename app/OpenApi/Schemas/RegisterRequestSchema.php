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
    /**
     * @return SchemaContract
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        $phone = Schema::string('phone');
        $email = Schema::string('email');
        $name = Schema::string('name');
        $password = Schema::string('pasword');
        $deviceName = Schema::string('deviceName');
        $phoneRequired = Schema::object()
            ->description('Phone Required')
            ->required($phone, $name, $password, $deviceName)
            ->properties($phone, $email, $name, $password, $deviceName);
        $emailRequired = Schema::object()
            ->description('Email Required')
            ->required($email, $name, $password, $deviceName)
            ->properties($phone, $email, $name, $password, $deviceName);

        return AnyOf::create('RegisterRequest')->schemas($phoneRequired, $emailRequired);
    }

}
