<?php
declare (strict_types=1);

namespace Project\Controller;

use Project\Configuration;
use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;
use Project\Module\Notification\NotificationService;
use Project\Module\User\User;
use Project\Module\User\UserService;

use Project\Service\JsPluginService;
use Project\Utilities\Tools;
use Project\View\PageInterface;
use Project\View\ViewRenderer;

/**
 * Class DefaultController
 * @package Project\Controller
 */
class DefaultController
{
    /** @var string HEADER_LOCATION */
    protected const HEADER_LOCATION = 'Location: ';

    /** @var ViewRenderer $viewRenderer */
    protected $viewRenderer;

    /** @var Configuration $configuration */
    protected $configuration;

    /** @var Database $database */
    protected $database;

    /** @var  User $loggedInUser */
    protected $loggedInUser;

    /** @var  UserService $userService */
    protected $userService;

    /** @var NotificationService $notificationService */
    protected $notificationService;

    /**
     * DefaultController constructor.
     *
     * @param Configuration $configuration
     * @param string        $routeName
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function __construct(Configuration $configuration, string $routeName)
    {
        $this->configuration = $configuration;
        $this->viewRenderer = new ViewRenderer($this->configuration);
        $this->database = new Database($this->configuration);
        $this->userService = new UserService($this->database);
        $this->notificationService = new NotificationService();

        if (Tools::getValue('userId') !== false) {
            $userId = Id::fromString(Tools::getValue('userId'));
            $this->loggedInUser = $this->userService->getLoggedInUserByUserId($userId);
        }

        $this->setDefaultViewConfig();

        $this->setJsPackages($routeName);
    }

    /**
     * Sets default view parameter for sidebar etc.
     */
    protected function setDefaultViewConfig(): void
    {
        try {
            $projectData = $this->configuration->getEntryByName('project');
            if (empty($projectData['name']) === false) {
                $this->viewRenderer->addViewConfig('projectName', $projectData['name']);
            }
        } catch (\InvalidArgumentException $exception) {
            $this->viewRenderer->addViewConfig('projectName', '');
        }

        $this->viewRenderer->addViewConfig('page', PageInterface::PAGE_ERROR['template']);
        $this->viewRenderer->addViewConfig('title', PageInterface::PAGE_ERROR['title']);

        /**
         * Logged In User
         */
        if ($this->loggedInUser !== null) {
            $this->viewRenderer->addViewConfig('loggedInUser', $this->loggedInUser);
        }

        /**
         * Notifications
         */
        $notifications = $this->notificationService->getNotifications(false);

        $this->viewRenderer->addViewConfig('notifications', $notifications);
    }

    /**
     * @param string $routeName
     *
     * @throws \InvalidArgumentException
     */
    protected function setJsPackages(string $routeName): void
    {
        $jsPlugInService = new JsPluginService($this->configuration);

        $jsMainPackage = $jsPlugInService->getMainPackages();
        $this->viewRenderer->addViewConfig('jsPlugins', $jsMainPackage);

        $jsRoutePackage = $jsPlugInService->getPackagesByRouteName($routeName);
        $this->viewRenderer->addViewConfig('jsRoutePlugins', $jsRoutePackage);
    }

    /**
     * not found action
     * @throws \Twig_Error_Syntax
     * @throws \InvalidArgumentException
     * @throws \Twig_Error_Runtime
     */
    public function notFoundAction(): void
    {
        try {
            $this->viewRenderer->renderTemplate(PageInterface::PAGE_NOTFOUND);
        } catch (\Twig_Error_Loader $error) {
            echo 'Alles ist kaputt!';
        }
    }

    /**
     * error action
     * @throws \Twig_Error_Runtime
     * @throws \InvalidArgumentException
     * @throws \Twig_Error_Syntax
     * @throws \Twig_Error_Loader
     */
    public function errorPageAction(): void
    {
        $this->showStandardPage(PageInterface::PAGE_ERROR);
    }

    /**
     * @param array $page
     *
     * @throws \InvalidArgumentException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    protected function showStandardPage(array $page): void
    {
        try {
            $this->viewRenderer->renderTemplate($page);
        } catch (\InvalidArgumentException $error) {
            $this->notFoundAction();
        }
    }
}