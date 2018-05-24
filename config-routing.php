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
        'login-redirect' => [
            'controller' => 'IndexController',
            'action' => 'loginRedirectAction'
        ],
        'sendmail' => [
            'controller' => 'MailerController',
            'action' => 'sendMailAction'
        ],
        'backend' => [
            'controller' => 'BackendController',
            'action' => 'backendAction'
        ],
        'logout' => [
            'controller' => 'BackendController',
            'action' => 'logoutAction'
        ]
    ]
];