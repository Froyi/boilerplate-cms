<?php
declare (strict_types=1);

namespace Project\Module\Image;

use Project\Module\DefaultModel;
use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Title;

/**
 * Class Image
 * @package Project\Module\Image
 */
class Image extends DefaultModel
{
    /** @var Id $imageId */
    protected $imageId;

    /** @var string $imageUrl */
    protected $imageUrl;

    /** @var Title $title */
    protected $title;

    /** @var Id $galeryId */
    protected $galeryId;

    /**
     * Image constructor.
     *
     * @param Id     $imageId
     * @param string $imageUrl
     * @param Id     $galeryId
     */
    public function __construct(Id $imageId, string $imageUrl, Id $galeryId)
    {
        $this->imageId = $imageId;
        $this->imageUrl = $imageUrl;
        $this->galeryId = $galeryId;
    }

    /**
     * @return Id
     */
    public function getImageId(): Id
    {
        return $this->imageId;
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    /**
     * @return Title
     */
    public function getTitle(): Title
    {
        return $this->title;
    }

    /**
     * @return Id
     */
    public function getGaleryId(): Id
    {
        return $this->galeryId;
    }

    /**
     * @param Title $title
     */
    public function setTitle(Title $title): void
    {
        $this->title = $title;
    }
}