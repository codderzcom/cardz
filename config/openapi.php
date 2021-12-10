<?php
return [
    'collections' => [

        'default' => [

            'info' => [
                'title' => config('app.name'),
                'description' => null,
                'version' => '2.0.0',
                'contact' => [],
            ],

            'servers' => [
                [
                    'url' => env('APP_URL'),
                    'description' => null,
                    'variables' => [],
                ],
                [
                    'url' => 'http://localhost',
                    'description' => null,
                    'variables' => [],
                ],
                [
                    'url' => 'http://localhost:8000',
                    'description' => null,
                    'variables' => [],
                ],
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
                    'name' => 'workspace',
                    'description' => 'Pertains to workspace-specific operations',
                ],

            ],
        ],
    ],
];
