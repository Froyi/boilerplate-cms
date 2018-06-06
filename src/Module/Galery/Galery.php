<?php
declare (strict_types=1);

namespace Project\Module\Galery;

use Project\Module\GenericValueObject\Date;
use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Title;
use Project\Module\Image\Image;

/**
 * Class Galery
 * @package Project\Module\Galery
 */
class Galery
{
    /** @var Id $galeryId */
    protected $galeryId;

    /** @var Title $title */
    protected $title;

    /** @var Date $galeryDate */
    protected $galeryDate;

    /** @var array $imageList */
    protected $imageList = [];

    /**
     * Galery constructor.
     * @param Id $galeryId
     * @param Title $title
     * @param Date $galeryDate
     */
    public function __construct(Id $galeryId, Title $title, Date $galeryDate)
    {
        $this->galeryId = $galeryId;
        $this->title = $title;
        $this->galeryDate = $galeryDate;
    }

    /**
     * @return Title
     */
    public function getTitle(): Title
    {
        return $this->title;
    }

    /**
     * @param Title $title
     */
    public function setTitle(Title $title): void
    {
        $this->title = $title;
    }

    /**
     * @return Id
     */
    public function getGaleryId(): Id
    {
        return $this->galeryId;
    }

    /**
     * @return Date
     */
    public function getGaleryDate(): Date
    {
        return $this->galeryDate;
    }

    /**
     * @param Date $galeryDate
     */
    public function setGaleryDate(Date $galeryDate): void
    {
        $this->galeryDate = $galeryDate;
    }

    /**
     * @param Image $image
     */
    public function addImageToImageList(Image $image): void
    {
        $this->imageList[$image->getImageId()->toString()] = $image;
    }

    /**
     * @param Id $imageId
     * @return bool
     */
    public function removeImageFromImageList(Id $imageId): bool
    {
        if (isset($this->imageList[$imageId->toString()])) {
            unset($this->imageList[$imageId->toString()]);

            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function getImageList(): array
    {
        return $this->imageList;
    }

    /**
     * delete image list
     */
    public function removeAllImagesFromList(): void
    {
        $this->imageList = [];
    }

    /**
     * @return int
     */
    public function getAmountOfImagesInGalery(): int
    {
        return \count($this->imageList);
    }

    /**
     * @param Id $imageId
     * @return null|Image
     */
    public function getImageFromImageListById(Id $imageId): ?Image
    {
        if (isset($this->imageList[$imageId->toString()])) {
            return $this->imageList[$imageId->toString()];
        }

        return null;
    }

    /**
     * @return Image
     */
    public function getGaleryPreviewImage(): Image
    {
        $randomImage = array_rand($this->imageList);

        return $this->imageList[$randomImage];
    }
}