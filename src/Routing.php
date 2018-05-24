<?php
declare (strict_types=1);

namespace Project;

/**
 * Class Routing
 * @package Project
 */
class Routing implements RoutingInterface
{
    /** @var array $routeConfiguration */
    protected $routeConfiguration;

    /** @var  string $projectNamespace */
    protected $projectNamespace;

    /** @var  string $controllerNamespace */
    protected $controllerNamespace;

    /** @var Configuration $configuration */
    protected $configuration;

    /** @var string $actionSuffix */
    protected $actionSuffix;

    /**
     * Routing constructor.
     * @param Configuration $configuration
     * @throws \InvalidArgumentException
     */
    public function __construct(Configuration $configuration)
    {
        $this->routeConfiguration = $configuration->getEntryByName('route');
        $this->controllerNamespace = $configuration->getEntryByName('controller')['namespace'];
        $this->actionSuffix = $configuration->getEntryByName('controller')['actionSuffix'];
        $this->projectNamespace = $configuration->getEntryByName('project')['namespace'];
        $this->configuration = $configuration;
    }

    /**
     * @param string $routeName
     *
     * @throws \InvalidArgumentException
     */
    public function startRoute(string $routeName): void
    {
        if (isset($this->routeConfiguration[$routeName]) === false) {
            if (isset($this->routeConfiguration[self::ROUTE_ERROR]) === false) {
                throw new \InvalidArgumentException('There is no valid Route. Look in the config for mapping.');
            }

            $routeController = $this->routeConfiguration[self::ROUTE_ERROR];
        } else {
            $routeController = $this->routeConfiguration[$routeName];
        }

        $controllerName = $this->projectNamespace . '\\' . $this->controllerNamespace . '\\' . $routeController;
        $actionName = $routeName . $this->actionSuffix;

        $controller = new $controllerName($this->configuration, $routeName);
        $controller->$actionName();
    }
}