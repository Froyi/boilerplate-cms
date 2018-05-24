<?php
declare (strict_types=1);

namespace Project\Controller;

use Project\Configuration;
use Project\Routing;
use Project\Utilities\Tools;

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
            $this->showStandardPage(Routing::ERROR_ROUTE);
        }
    }

    /**
     * backend main site action
     * @throws \Twig_Error_Syntax
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Loader
     * @throws \InvalidArgumentException
     */
    public function backendAction(): void
    {
        $this->viewRenderer->addViewConfig('page', 'backend');
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
        header('Location: ' . Tools::getRouteUrl('index'));
    }



}