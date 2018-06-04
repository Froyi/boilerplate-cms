<?php declare (strict_types=1);

namespace Project\Controller;

use Project\Configuration;
use Project\Module\GenericValueObject\Id;
use Project\Module\News\NewsService;
use Project\Utilities\Tools;
use Project\View\JsonModel;

/**
 * Class JsonController
 * @package     Project\Controller
 * @copyright   Copyright (c) 2018 Maik Schößler
 */
class JsonController extends DefaultController
{
    /** @var JsonModel $jsonModel */
    protected $jsonModel;

    /**
     * JsonController constructor.
     *
     * @param Configuration $configuration
     * @param string        $routeName
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function __construct(Configuration $configuration, string $routeName)
    {
        parent::__construct($configuration, $routeName);

        $this->jsonModel = new JsonModel();
    }

    /**
     *  edit news template with to edit news
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function newsEditAction(): void
    {
        $newsService = new NewsService($this->database, $this->userService);
        $news = $newsService->getNewsByNewsId(Id::fromString(Tools::getValue('newsId')));
        $this->viewRenderer->addViewConfig('newsEdit', $news);

        try {
            $this->jsonModel->addJsonConfig('view', $this->viewRenderer->renderJsonView('backend/module/news/partial/newsEdit.twig'));
            $this->jsonModel->send();
        } catch (\Twig_Error_Loader | \Twig_Error_Runtime | \Twig_Error_Syntax $exception) {
            $this->jsonModel->send('error');
        }
    }
}