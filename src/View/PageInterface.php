<?php declare(strict_types=1);

namespace Project\View;


/**
 * Interface PageInterface
 * @package     Project\View
 */
interface PageInterface
{
    public const PAGE_HOME = 'home';

    public const PAGE_ERROR = 'error';

    public const PAGE_BACKEND_DASHBOARD = 'dashboard';

    public const PAGE_BACKEND_NEWS = 'news';

    public const PAGE_BACKEND_GALLERY = 'gallery';

    public const PAGE_BACKEND_SETTINGS = 'settings';

    public const PAGE_LOGIN = 'login';

    public const PAGE_NOTFOUND = 'notfound';
}