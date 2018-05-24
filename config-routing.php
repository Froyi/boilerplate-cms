<?php
return [
    'route' => [
        'index' => [
            'controller' => 'IndexController',
            'action' => 'indexAction'
        ],
        'login' => [
            'controller' => 'IndexController',
            'action' => 'loginAction'
        ],
        'sendmail' => [
            'controller' => 'MailerController',
            'action' => 'sendMailAction'
        ]
    ]
];