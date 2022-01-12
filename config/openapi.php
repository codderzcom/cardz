<?php
return [
    'collections' => [

        'default' => [

            'info' => [
                'title' => config('app.name'),
                'author' => config('app.author'),
                'description' => config('app.description'),
                'version' => config('app.version'),
                'contact' => [],
            ],

            'middlewares' => [
                'paths' => [
                    \App\OpenApi\Middleware\ApiV1Middleware::class,
                ],
            ],

            'servers' => [
                [
                    'url' => env('APP_URL') . '/api/v1',
                    'description' => 'App Environment',
                    'variables' => [],
                ],
                [
                    'url' => 'http://localhost:8000/api/v1',
                    'description' => 'Default',
                    'variables' => [],
                ],
            ],

            'security' => [
                GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityRequirement::create()->securityScheme('BearerToken'),
            ],

            'tags' => [
                [
                    'name' => 'customer',
                    'description' => 'Pertains to customer operations',
                ],

                [
                    'name' => 'business',
                    'description' => 'Pertains to all workspace operations',
                ],

                [
                    'name' => 'card',
                    'description' => 'Pertains to workspace operations with cards',
                ],

                [
                    'name' => 'collaboration',
                    'description' => 'Pertains to workspace operations with collaboration',
                ],

                [
                    'name' => 'plan',
                    'description' => 'Pertains to workspace operations with plans',
                ],

                [
                    'name' => 'requirement',
                    'description' => 'Pertains to workspace operations with requirements in a plan',
                ],

                [
                    'name' => 'workspace',
                    'description' => 'Pertains to workspace-specific operations',
                ],

            ],
        ],
    ],
];
