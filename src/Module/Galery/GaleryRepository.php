<?php
declare (strict_types=1);

namespace Project\Module\Galery;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;

/**
 * Class GaleryRepository
 * @package Project\Module\Galery
 */
class GaleryRepository
{
    protected const TABLE = 'galery';

    protected const GALERY_ORDERBY = 'galeryDate';

    protected const GALERY_ID = 'galeryId';

    protected const GALERY_ORDERKIND = 'DESC';

    /** @var  Database $database */
    protected $database;

    /**
     * GaleryRepository constructor.
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
    public function getAllGaleries(): array
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->orderBy(self::GALERY_ORDERBY, self::GALERY_ORDERKIND);

        return $this->database->fetchAll($query);
    }

    /**
     * @param Id $galeryId
     *
     * @return mixed
     * @throws \RuntimeException
     */
    public function getGaleryByGaleryId(Id $galeryId)
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where(self::GALERY_ID, '=', $galeryId->toString());

        return $this->database->fetch($query);
    }

    /**
     * @param Galery $galery
     *
     * @return bool
     * @throws \RuntimeException
     */
    public function saveGalery(Galery $galery): bool
    {
        if (!empty($this->getGaleryByGaleryId($galery->getGaleryId()))) {
            $query = $this->database->getNewUpdateQuery(self::TABLE);
            $query->set('galeryId', $galery->getGaleryId()->toString());
            $query->set('title', $galery->getTitle()->getTitle());
            $query->set('galeryDate', $galery->getGaleryDate()->toString());

            $query->where('galeryId', '=', $galery->getGaleryId()->toString());

            return $this->database->execute($query);
        }

        $query = $this->database->getNewInsertQuery(self::TABLE);
        $query->insert('galeryId', $galery->getGaleryId()->toString());
        $query->insert('title', $galery->getTitle()->getTitle());
        $query->insert('galeryDate', $galery->getGaleryDate()->toString());

        return $this->database->execute($query);
    }

    /**
     * @param Galery $galery
     *
     * @return bool
     * @throws \RuntimeException
     */
    public function deleteGalery(Galery $galery): bool
    {
        $query = $this->database->getNewDeleteQuery(self::TABLE);
        $query->where('galeryId', '=', $galery->getGaleryId()->toString());

        return $this->database->execute($query);
    }
}