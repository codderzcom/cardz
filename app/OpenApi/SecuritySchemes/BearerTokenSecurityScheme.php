<?php

namespace App\OpenApi\SecuritySchemes;

use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;

class BearerTokenSecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create('BearerToken')
            ->name('BearerToken')
            ->type(SecurityScheme::TYPE_HTTP)
            ->in(SecurityScheme::IN_HEADER)
            ->scheme('bearer')
            ->bearerFormat('JWT');
    }
}
