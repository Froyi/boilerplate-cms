<?php
declare (strict_types=1);

namespace Project\View;

use Project\Configuration;
use Project\Utilities\Converter;
use Project\Utilities\Tools;
use Project\View\ValueObject\TemplateDir;

/**
 * Class ViewRenderer
 * @package Project\View
 */
class ViewRenderer
{
    /** @var string DEFAULT_PAGE_TEMPLATE */
    public const DEFAULT_PAGE_TEMPLATE = 'index.twig';

    public const DEFAULT_PAGE_BACKEND_TEMPLATE = 'backend/backend.twig';

    /** @var TemplateDir $templateDir */
    protected $templateDir;

    /** @var \Twig_Environment $viewRenderer */
    protected $viewRenderer;

    /** @var  string $templateName */
    protected $templateName;

    /** @var  array $config */
    protected $config = [];

    /** @var string $defaultPageTemplate */
    protected $defaultPageTemplate = self::DEFAULT_PAGE_TEMPLATE;

    /**
     * ViewRenderer constructor.
     *
     * @param Configuration $configuration
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(Configuration $configuration)
    {
        $template = $configuration->getEntryByName('template');

        $this->templateDir = TemplateDir::fromString($template['dir']);
        $this->templateName = $template['name'];

        $loaderFilesystem = new \Twig_Loader_Filesystem($this->templateDir->getTemplateDir());
        $this->viewRenderer = new \Twig_Environment($loaderFilesystem);

        $this->addViewFilter();

        $templateDir = 'templates/' . $this->templateName;

        $this->addViewConfig('templateDir', $templateDir);
        $this->addViewConfig('mainCssPath', $templateDir . $template['main_css_path']);
    }

    /**
     * @param array|null $pageParameter
     * @param string     $template
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function renderTemplate(array $pageParameter = null, string $template = null): void
    {
        if ($pageParameter !== null && empty($pageParameter) === false) {
            $this->addViewConfig('page', $pageParameter['template']);
            $this->addViewConfig('title', $pageParameter['title']);
        }

        if ($template === null) {
            echo $this->viewRenderer->render($this->getDefaultPageTemplate(), $this->config);
        } else {
            echo $this->viewRenderer->render($template, $this->config);
        }
    }

    /**
     * @param string $template
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function renderJsonView(string $template = self::DEFAULT_PAGE_TEMPLATE): string
    {
        return $this->viewRenderer->render($template, $this->config);
    }

    /**
     * @return string
     */
    public function getDefaultPageTemplate(): string
    {
        return $this->defaultPageTemplate;
    }

    /**
     * @param string $defaultPageTemplate
     */
    public function setDefaultPageTemplate(string $defaultPageTemplate): void
    {
        $this->defaultPageTemplate = $defaultPageTemplate;
    }

    /**
     * Add filter
     * @throws \InvalidArgumentException
     */
    protected function addViewFilter(): void
    {
        $weekDayFilter = new \Twig_SimpleFilter('weekday', function ($integer) {
            return Converter::convertIntToWeekday($integer);
        });

        $this->viewRenderer->addFilter($weekDayFilter);

        $weekDayShortFilter = new \Twig_SimpleFilter('weekdayShort', function ($integer) {
            return Converter::convertIntToWeekdayShort($integer);
        });

        $this->viewRenderer->addFilter($weekDayShortFilter);

        $routeFilter = new \Twig_SimpleFunction('route', function (string $route = '', $parameter = []) {
            return Tools::getRouteUrl($route, $parameter);
        });

        $this->viewRenderer->addFunction($routeFilter);

        $shortenFilter = new \Twig_SimpleFunction('shortener',
            function (string $text = '', int $amount = 50, bool $points = true) {
                return Tools::shortener($text, $amount, $points);
            });

        $this->viewRenderer->addFunction($shortenFilter);
    }

    /**
     * @param string $name
     * @param        $value
     */
    public function addViewConfig(string $name, $value): void
    {
        $this->config[$name] = $value;
    }

    /**
     * @param string $name
     */
    public function removeViewConfig(string $name): void
    {
        if (isset($this->config[$name])) {
            unset($this->config[$name]);
        }
    }
}