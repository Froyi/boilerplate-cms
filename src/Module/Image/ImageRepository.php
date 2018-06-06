<?php declare(strict_types=1);

namespace Project\Module\Image;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;

/**
 * Class ImageRepository
 * @package     Project\Module\Image
 */
class ImageRepository
{
    /** @var string IMAGE_TABLE */
    protected const TABLE = 'image';

    /** @var string IMAGE_ORDERBY */
    protected const IMAGE_ORDERBY = 'imageId';

    /** @var string IMAGE_ID */
    protected const IMAGE_ID = 'imageId';

    /** @var string IMAGE_ORDERKIND */
    protected const IMAGE_ORDERKIND = 'ASC';

    /** @var Database $database */
    protected $database;

    /**
     * ImageRepository constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @param Id $imageId
     *
     * @return mixed
     * @throws \RuntimeException
     */
    public function getImageByImageId(Id $imageId)
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('imageId', '=', $imageId->toString());

        return $this->database->fetch($query);
    }

    /**
     * @param Id $galeryId
     *
     * @return mixed
     * @throws \RuntimeException
     */
    public function getImagesByGaleryId(Id $galeryId)
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('galeryId', '=', $galeryId->toString());

        return $this->database->fetchAll($query);
    }

    /**
     * @param Image $image
     *
     * @return bool
     * @throws \RuntimeException
     */
    public function saveImage(Image $image): bool
    {
        if (!empty($this->getImageByImageId($image->getImageId()))) {
            $query = $this->database->getNewUpdateQuery(self::TABLE);
            $query->set('imageId', $image->getImageId()->toString());
            $query->set('title', $image->getTitle()->getTitle());
            $query->set('imageUrl', $image->getImageUrl());
            $query->set('galeryId', $image->getGaleryId()->toString());

            $query->where('imageId', '=', $image->getImageId()->toString());

            return $this->database->execute($query);
        }

        $query = $this->database->getNewInsertQuery(self::TABLE);
        $query->insert('imageId', $image->getImageId()->toString());
        $query->insert('title', $image->getTitle()->getTitle());
        $query->insert('imageUrl', $image->getImageUrl());
        $query->insert('galeryId', $image->getGaleryId()->toString());

        return $this->database->execute($query);
    }
}