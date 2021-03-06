<?php declare(strict_types=1);

namespace Project;

/**
 * Interface RoutingInterface
 * @package     Project
 */
interface RoutingInterface
{
    /** @var string CONTROLLER_INDEX */
    public const CONTROLLER_INDEX = 'IndexController';

    /** @var string CONTROLLER_BACKEND */
    public const CONTROLLER_BACKEND = 'BackendController';

    /** @var string CONTROLLER_JSON */
    public const CONTROLLER_JSON = 'JsonController';

    /** @var string CONTROLLER_MAILER */
    public const CONTROLLER_MAILER = 'MailerController';

    /** @var string ROUTE_INDEX */
    public const ROUTE_INDEX = 'index';

    /** @var string ROUTE_LOGIN */
    public const ROUTE_LOGIN = 'login';

    /** @var string ROUTE_LOGIN_REDIRECT */
    public const ROUTE_LOGIN_REDIRECT = 'loginRedirect';

    /** @var string ROUTE_SEND_MAIL */
    public const ROUTE_SEND_MAIL = 'sendmail';

    /** @var string ROUTE_DASHBOARD */
    public const ROUTE_BACKEND_DASHBOARD = 'dashboard';

    /** @var string ROUTE_BACKEND_NEWS */
    public const ROUTE_BACKEND_NEWS = 'news';

    /** @var string ROUTE_BACKEND_GALERY */
    public const ROUTE_BACKEND_GALERY = 'galery';

    /** @var string ROUTE_BACKEND_SETTINGS */
    public const ROUTE_BACKEND_SETTINGS = 'settings';

    /** @var string ROUTE_BACKEND_NEWS_CREATE */
    public const ROUTE_BACKEND_NEWS_CREATE = 'newsCreate';

    /** @var string ROUTE_BACKEND_NEWS_DELETE */
    public const ROUTE_BACKEND_NEWS_DELETE = 'newsDelete';

    /** @var string ROUTE_BACKEND_NEWS_EDIT_SUBMIT */
    public const ROUTE_BACKEND_NEWS_EDIT_SUBMIT = 'newsEditSubmit';

    /** @var string ROUTE_JSON_NEWS_EDIT */
    public const ROUTE_JSON_NEWS_EDIT = 'newsEdit';

    public const ROUTE_BACKEND_GALERY_CREATE = 'galeryCreate';

    /** @var string ROUTE_LOGOUT */
    public const ROUTE_LOGOUT = 'logout';

    /** @var string ERROR_ROUTE */
    public const ROUTE_ERROR = 'notfound';
}