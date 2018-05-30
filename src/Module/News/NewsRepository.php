<?php
declare(strict_types=1);

namespace Project\Module\News;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;

/**
 * Class NewsRepository
 * @package     Project\Module\News
 */
class NewsRepository
{
    /** @var string TABLE */
    protected const TABLE = 'news';

    /** @var string ORDERBY */
    protected const ORDERBY = 'created';

    /** @var string ORDERKIND */
    protected const ORDERKIND = 'DESC';

    /** @var string IDENTIFIER */
    protected const IDENTIFIER = 'newsId';

    /** @var  Database $database */
    protected $database;

    /**
     * NewsRepository constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @return array
     * @throws \RuntimeException
     */
    public function getAllNews(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->orderBy(self::ORDERBY, self::ORDERKIND);

        return $this->database->fetchAll($query);
    }

    /**
     * @param Id $newsId
     *
     * @return mixed
     * @throws \RuntimeException
     */
    public function getNewsByNewsId(Id $newsId)
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('newsId', '=', $newsId->toString());

        return $this->database->fetch($query);
    }

    /**
     * @param News $news
     *
     * @return bool
     * @throws \RuntimeException
     */
    public function saveNews(News $news): bool
    {
        if (!empty($this->getNewsByNewsId($news->getNewsId()))) {
            $query = $this->database->getNewUpdateQuery(self::TABLE);
            $query->set('newsId', $news->getNewsId()->toString());
            $query->set('title', $news->getTitle()->getTitle());
            $query->set('text', $news->getText()->getText());
            $query->set('created', $news->getCreated()->toString());
            $query->set('userId', $news->getUser()->getUserId()->toString());

            $query->where('newsId', '=', $news->getNewsId()->toString());

            return $this->database->execute($query);
        }

        $query = $this->database->getNewInsertQuery(self::TABLE);
        $query->insert('newsId', $news->getNewsId()->toString());
        $query->insert('title', $news->getTitle()->getTitle());
        $query->insert('text', $news->getText()->getText());
        $query->insert('created', $news->getCreated()->toString());
        $query->insert('userId', $news->getUser()->getUserId()->toString());

        return $this->database->execute($query);
    }

    /**
     * @param News $news
     *
     * @return bool
     * @throws \RuntimeException
     */
    public function deleteNews(News $news): bool
    {
        $query = $this->database->getNewDeleteQuery(self::TABLE);
        $query->where('newsId', '=', $news->getNewsId()->toString());

        return $this->database->execute($query);
    }
}