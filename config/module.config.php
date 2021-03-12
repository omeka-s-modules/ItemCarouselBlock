<?php
namespace CarouselBrowseBlock;

return [
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ]
    ],
	'block_layouts' => [
        'invokables' => [
            'carousel' => Site\BlockLayout\Carousel::class,
        ],
    ]
];