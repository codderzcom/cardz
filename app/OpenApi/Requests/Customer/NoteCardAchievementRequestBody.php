<?php

namespace App\OpenApi\Requests\Customer;

use App\OpenApi\Schemas\AchievementRequestSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class NoteCardAchievementRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('NoteCardAchievement')
            ->description('Note card achievement request')
            ->content(
                MediaType::json()->schema(AchievementRequestSchema::ref())
            );
    }

}
