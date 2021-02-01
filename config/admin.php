<?php

return [
	'jqadm' => [
        'swpost' => [
            'standard' => [
                'subparts' => [
                    'media' => 'media',
                    'text' => 'text',
                ],
            ],
            'domains' => [
                'media' => 'media',
                'text' => 'text',
            ],
        ],
        'navbar' => [
            'swblog'=>['swpost', 'type/swpost']
         ],
        'resource' =>[
            'swpost' => [
                'groups' => ['admin', 'editor', 'super'],
                'key' => 'SWP',
            ],
            'swblog' => [
                'groups' => ['admin', 'editor', 'super'],
                'key' => 'SWB',
            ],
        ],
    ],
	'jsonadm' => [

	],
];
    
