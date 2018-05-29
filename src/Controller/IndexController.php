<?php
declare (strict_types=1);

namespace Project\Controller;

use Project\Module\GenericValueObject\Email;
use Project\Module\GenericValueObject\Password;
use Project\RoutingInterface;
use Project\Utilities\Tools;
use Project\View\PageInterface;

/**
 * Class IndexController
 * @package Project\Controller
 */
class IndexController extends DefaultController
{
    /**
     * index action (standard page)
     *
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Loader
     * @throws \InvalidArgumentException
     * @throws \Twig_Error_Syntax
     */
    public function indexAction(): void
    {
        $this->showStandardPage(PageInterface::PAGE_HOME);
    }

    /**
     * action for login page
     *
     * @throws \InvalidArgumentException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function loginAction(): void
    {
        if ($this->loggedInUser !== null) {
            $this->redirectToBackendPage();
        } else {
            $this->showStandardPage(PageInterface::PAGE_LOGIN);
        }
    }

    /**
     * action after pressing login button
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function loginRedirectAction(): void
    {
        if ($this->loggedInUser === null) {
            $password = Password::fromString(Tools::getValue('password'));
            $email = Email::fromString(Tools::getValue('email'));
            $this->loggedInUser = $this->userService->getLoggedInUserByEmailAndPassword($email, $password);
        }

        if ($this->loggedInUser !== null) {
            $this->redirectToBackendPage();
        } else {
            header('Location: ' . Tools::getRouteUrl(RoutingInterface::ROUTE_LOGIN));
        }
    }

    /**
     * redirect to backend site
     */
    protected function redirectToBackendPage(): void
    {
        header('Location: ' . Tools::getRouteUrl(RoutingInterface::ROUTE_DASHBOARD));
    }
}