<?php
declare (strict_types=1);

namespace Project\Controller;

use Project\Configuration;
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
     * @throws \Twig_Error_Syntax
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Loader
     * @throws \InvalidArgumentException
     */
    public function dashboardAction(): void
    {
        $this->viewRenderer->addViewConfig('page', PageInterface::PAGE_BACKEND_DASHBOARD);
        $this->viewRenderer->renderTemplate();
    }

    /**
     * backend main site action
     * @throws \Twig_Error_Syntax
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Loader
     * @throws \InvalidArgumentException
     */
    public function newsAction(): void
    {
        $this->viewRenderer->addViewConfig('page', PageInterface::PAGE_BACKEND_NEWS);
        $this->viewRenderer->renderTemplate();
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
        $this->viewRenderer->addViewConfig('page', PageInterface::PAGE_BACKEND_GALLERY);
        $this->viewRenderer->renderTemplate();
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
        $this->viewRenderer->addViewConfig('page', PageInterface::PAGE_BACKEND_SETTINGS);
        $this->viewRenderer->renderTemplate();
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