<?php
declare(strict_types=1);

namespace Project\Module\News;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Datetime;
use Project\Module\GenericValueObject\Id;
use Project\Module\User\User;
use Project\Module\User\UserService;

/**
 * Class NewsService
 * @package     Project\Module\News
 */
class NewsService
{
    /** @var  NewsFactory $newsFactory */
    protected $newsFactory;

    /** @var  NewsRepository $newsRepository */
    protected $newsRepository;

    /** @var UserService $userService */
    protected $userService;

    /**
     * NewsService constructor.
     *
     * @param Database    $database
     * @param UserService $userService
     */
    public function __construct(Database $database, UserService $userService)
    {
        $this->newsFactory = new NewsFactory();
        $this->newsRepository = new NewsRepository($database);

        $this->userService = $userService;
    }

    /**
     * @return array
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function getAllNewsOrderByDate(): array
    {
        $news = [];

        $newsResult = $this->newsRepository->getAllNews();

        if (\count($newsResult) === 0) {
            return $news;
        }

        foreach ($newsResult as $singleNews) {
            $user = $this->getUserByNewsData($singleNews);

            if ($user === null) {
                continue;
            }

            $news[] = $this->newsFactory->getNewsFromObject($singleNews, $user);
        }

        return $news;
    }

    /**
     * @param $newsData
     *
     * @return null|User
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    protected function getUserByNewsData($newsData): ?User
    {
        if (empty($newsData->userId) === true) {
            return null;
        }

        return $this->userService->getUserByUserId(Id::fromString($newsData->userId));
    }

    /**
     * @param Id $newsId
     *
     * @return null|News
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function getNewsByNewsId(Id $newsId): ?News
    {
        $newsResult = $this->newsRepository->getNewsByNewsId($newsId);

        $user = $this->getUserByNewsData($newsResult);

        if ($user === null) {
            return null;
        }

        return $this->newsFactory->getNewsFromObject($newsResult, $user);
    }

    /**
     * @param array $parameter
     *
     * @return null|News
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function getNewsByParams(array $parameter): ?News
    {
        $objectParameter = (object)$parameter;

        if (!isset($objectParameter->newsId) || (isset($objectParameter->newsId) && empty($objectParameter->newsId))) {
            $objectParameter->newsId = Id::generateId()->toString();
        }

        if (!isset($objectParameter->created) || (isset($objectParameter->created) && empty($objectParameter->created))) {
            $objectParameter->created = Datetime::fromNow()->toString();
        }

        $user = $this->getUserByNewsData($objectParameter);

        if ($user === null) {
            return null;
        }

        return $this->newsFactory->getNewsFromObject($objectParameter, $user);
    }

    /**
     * @param News $news
     *
     * @return bool
     * @throws \RuntimeException
     */
    public function saveNews(News $news): bool
    {
        return $this->newsRepository->saveNews($news);
    }

    /**
     * @param News $news
     *
     * @return bool
     * @throws \RuntimeException
     */
    public function deleteNews(News $news): bool
    {
        return $this->newsRepository->deleteNews($news);
    }
}