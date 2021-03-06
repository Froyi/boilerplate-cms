<?php
use Project\ConfigurationInterface;

return [
    'project' => [
        'name' => 'CMS',
        'namespace' => 'Project'
    ],
    'template' => [
        'name' => 'default',
        'dir' =>  '/default',
        'main_css_path' => '/css/main.css',
        'backend' => [
            'dir' => '/backend'
        ,]
    ],
    'database_live' => [
        'host' => ConfigurationInterface::DEFAULT_SERVER,
        ConfigurationInterface::USER => 'web1061',
        ConfigurationInterface::PASS => 'EB57l0Kq',
        'database_name' => 'usr_web1061_1'
    ],
    'database' => [
        'host' => ConfigurationInterface::DEFAULT_SERVER,
        ConfigurationInterface::USER => 'root',
        ConfigurationInterface::PASS => '',
        'database_name' => 'boilerplate_cms'
    ],
    'controller' => [
        'namespace' => 'Controller',
        'actionSuffix' => 'Action'
    ],
    'mailer' => [
        'server' => ConfigurationInterface::DEFAULT_SERVER,
        'port' => 25,
        ConfigurationInterface::USER => 'web1061p1',
        ConfigurationInterface::PASS => 'j5q9hCZp',
        'standard_from_mail' => 'test@boilerplate.ms2002.alfahosting.org',
        'standard_from_name' => 'John Doe'
    ]
];