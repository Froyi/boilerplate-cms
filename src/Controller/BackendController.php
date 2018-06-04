<?php
declare (strict_types=1);

namespace Project\Controller;

use Project\Configuration;
use Project\Module\GenericValueObject\Id;
use Project\Module\News\NewsService;
use Project\RoutingInterface;
use Project\Utilities\Tools;
use Project\View\PageInterface;
use Project\View\ViewRenderer;

/**
 * Class BackendController
 * @package Project\Controller
 */
class BackendController extends DefaultController
{
    /**
     * BackendController constructor.
     *
     * @param Configuration $configuration
     * @param string        $routeName
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __construct(Configuration $configuration, string $routeName)
    {
        parent::__construct($configuration, $routeName);

        if ($this->loggedInUser === null) {
            $this->showStandardPage(PageInterface::PAGE_LOGIN);
            exit;
        }

        // set new templateDir
        $this->viewRenderer->setDefaultPageTemplate(ViewRenderer::DEFAULT_PAGE_BACKEND_TEMPLATE);
    }

    /**
     * backend main site action
     * @throws \RuntimeException
     * @throws \Twig_Error_Syntax
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Loader
     * @throws \InvalidArgumentException
     */
    public function dashboardAction(): void
    {
        $newsService = new NewsService($this->database, $this->userService);
        $news = $newsService->getAllNewsOrderByDate();
        if (empty($news) === false) {
            $this->viewRenderer->addViewConfig('news', $news);
        }

        $this->viewRenderer->renderTemplate(PageInterface::PAGE_BACKEND_DASHBOARD);
    }

    /**
     * backend main site action
     * @throws \RuntimeException
     * @throws \Twig_Error_Syntax
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Loader
     * @throws \InvalidArgumentException
     */
    public function newsAction(): void
    {
        $newsService = new NewsService($this->database, $this->userService);
        $newsEdit = $newsService->getAllNewsOrderByDate();

        $this->viewRenderer->addViewConfig('newsEdit', $newsEdit);
        $this->viewRenderer->renderTemplate(PageInterface::PAGE_BACKEND_NEWS);
    }

    /**
     * Create a new news.
     */
    public function newsCreateAction(): void
    {
        $newsService = new NewsService($this->database, $this->userService);

        try {
            $news = $newsService->getNewsByParams($_POST);
            if ($news === null) {
                $this->notificationService->setError('Die Daten sind nicht komplett und in ausreichender Qualität eingegeben worden.');
            } else {
                if ($newsService->saveNews($news) === true) {
                    $this->notificationService->setSuccess('Die News konnte erfolgreich gespeichert werden.');
                } else {
                    $this->notificationService->setError('Die News konnte nicht gespeichert werden.');
                }
            }
        } catch (\InvalidArgumentException | \RuntimeException $exception) {
            $this->notificationService->setError('Die Daten sind fehlerhaft.');
        }

        header('Location: ' . Tools::getRouteUrl(RoutingInterface::ROUTE_BACKEND_NEWS));
    }

    /**
     * Save the edited neas in repository.
     */
    public function newsEditSubmitAction(): void
    {
        $newsService = new NewsService($this->database, $this->userService);

        try {
            $news = $newsService->getNewsByParams($_POST);
            if ($news === null) {
                $this->notificationService->setError('Die Daten sind nicht komplett und in ausreichender Qualität eingegeben worden.');
            } else {
                if ($newsService->saveNews($news) === true) {
                    $this->notificationService->setSuccess('Die News konnte erfolgreich bearbeitet werden.');
                } else {
                    $this->notificationService->setError('Die News konnte nicht bearbeitet werden.');
                }
            }
        } catch (\InvalidArgumentException | \RuntimeException $exception) {
            $this->notificationService->setError('Die Daten sind fehlerhaft.');
        }

        header('Location: ' . Tools::getRouteUrl(RoutingInterface::ROUTE_BACKEND_NEWS));
    }

    /**
     * Delete news in repository
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function newsDeleteAction(): void
    {
        $newsService = new NewsService($this->database, $this->userService);

        $newsId = Tools::getValue('newsId');
        if ($newsId === false) {
            $this->notificationService->setError('Die News konnte nicht gelöscht werden, da es keine gültigen Übergabeparameter gab.');
            header('Location: ' . Tools::getRouteUrl(RoutingInterface::ROUTE_BACKEND_NEWS));
            exit;
        }

        $newsId = Id::fromString($newsId);
        $news = $newsService->getNewsByNewsId($newsId);
        if ($news === null) {
            $this->notificationService->setError('Die News konnte nicht gelöscht werden, da es bereits keine News mehr gibt.');
            header('Location: ' . Tools::getRouteUrl(RoutingInterface::ROUTE_BACKEND_NEWS));
            exit;
        }

        if ($newsService->deleteNews($news) === true) {
            $this->notificationService->setSuccess('Die News konnte erfolgreich gelöscht werden.');
        } else {
            $this->notificationService->setError('Die News konnte nicht gelöscht werden, da es bereits keine News mehr gibt.');
        }

        header('Location: ' . Tools::getRouteUrl(RoutingInterface::ROUTE_BACKEND_NEWS));
    }

    /**
     * backend main site action
     * @throws \Twig_Error_Syntax
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Loader
     * @throws \InvalidArgumentException
     */
    public function galleryAction(): void
    {
        $this->viewRenderer->renderTemplate(PageInterface::PAGE_BACKEND_GALLERY);
    }

    /**
     * backend main site action
     * @throws \Twig_Error_Syntax
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Loader
     * @throws \InvalidArgumentException
     */
    public function settingsAction(): void
    {
        $this->viewRenderer->renderTemplate(PageInterface::PAGE_BACKEND_SETTINGS);
    }

    /**
     * logout user
     */
    public function logoutAction(): void
    {
        if ($this->userService->logoutUser($this->loggedInUser)) {
            $this->viewRenderer->removeViewConfig('loggedInUser');
        }

        /** redirect because of logout action */
        header('Location: ' . Tools::getRouteUrl(RoutingInterface::ROUTE_INDEX));
    }
}