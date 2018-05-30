<?php

use \Project\RoutingInterface;

return [
    'js-packages' => [
        'fancybox' => '/js/fancybox.min.js',
        'ckeditor' => '/ckeditor/ckeditor.js',
        'responsive-slides' => '/js/responsiveSlides.min.js',
        'jquery' => '/js/jquery-3.2.1.min.js',
        'pageslide' => '/js/jquery.pageslide.min.js',
        'main' => '/js/main.js',
        'notification' => '/js/module/notification.js',
    ],
    'js-boxes' => [
        // add here route name or add something to main package
        'main' => [
            'jquery' => true,
            'responsive-slides' => true,
            'pageslide' => false,
            'main' => true,
            'notification' => true,
        ],

        RoutingInterface::ROUTE_INDEX => [
            'fancybox' => true,
        ]
    ]
];