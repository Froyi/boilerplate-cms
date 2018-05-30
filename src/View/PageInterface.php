<?php declare(strict_types=1);

namespace Project\View;


/**
 * Interface PageInterface
 * @package     Project\View
 */
interface PageInterface
{
    public const PAGE_HOME = [
        'template' => 'home',
        'title' => 'Startseite'
    ];

    public const PAGE_ERROR = [
        'template' => 'error',
        'title' => 'Fehlerseite'
    ];

    public const PAGE_BACKEND_DASHBOARD = [
        'template' => 'dashboard',
        'title' => 'Dashboard'
    ];

    public const PAGE_BACKEND_NEWS = [
        'template' => 'news',
        'title' => 'News'
    ];

    public const PAGE_BACKEND_GALLERY = [
        'template' => 'gallery',
        'title' => 'Galerie'
    ];

    public const PAGE_BACKEND_SETTINGS = [
        'template' => 'settings',
        'title' => 'Einstellungen'
    ];

    public const PAGE_LOGIN = [
        'template' => 'login',
        'title' => 'Login'
    ];

    public const PAGE_NOTFOUND = [
        'template' => 'notfound',
        'title' => 'Fehlerseite'
    ];
}