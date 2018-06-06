<?php declare(strict_types=1);

namespace Project\Module\Image;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;

/**
 * Class ImageService
 * @package     Project\Module\Image
 */
class ImageService
{
    /** @var ImageFactory $imageFactory */
    protected $imageFactory;

    /** @var ImageRepository $imageRepository */
    protected $imageRepository;

    /**
     * ImageService constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->imageRepository = new ImageRepository($database);
        $this->imageFactory = new ImageFactory();
    }

    /**
     * @param Id $imageId
     *
     * @return null|Image
     */
    public function getImageByImageId(Id $imageId): ?Image
    {
        try {
            $imageData = $this->imageRepository->getImageByImageId($imageId);

            if (empty($imageData) === true) {
                return null;
            }

            return $this->imageFactory->getImageFromObject($imageData);
        } catch (\Exception $exception) {
            return null;
        }
    }

    /**
     * @param array       $parameter
     * @param Id|null     $galeryId
     * @param string|null $path
     *
     * @return null|Image
     */
    public function getImageByParameter(array $parameter, Id $galeryId = null, string $path = null): ?Image
    {
        try {
            $object = (object)$parameter;

            if (empty($object->imageUrl) === true && $path === null) {
                return null;
            }

            if (empty($object->galeryId) === true && $galeryId === null) {
                return null;
            }

            if (empty($object->imageUrl) === true) {
                $object->imageUrl = $path;
            }

            if (empty($object->galeryId) === true) {
                $object->galeryId = $galeryId->toString();
            }

            if (empty($object->imageId) === true) {
                $object->imageId = Id::generateId()->toString();
            }

            return $this->imageFactory->getImageFromObject($object);
        } catch (\Exception $exception) {
            return null;
        }
    }

    /**
     * @param Image $image
     *
     * @return bool
     */
    public function saveImage(Image $image): bool
    {
        try {
            return $this->imageRepository->saveImage($image);
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function getImagesByGaleryId(Id $galeryId): array
    {
        try {
            $images = [];

            $imagesData = $this->imageRepository->getImagesByGaleryId($galeryId);

            if (empty($imagesData) === true) {
                return $images;
            }

            foreach ($imagesData as $imageData) {
                $image = $this->imageFactory->getImageFromObject($imageData);

                if ($image !== null) {
                    $images[] = $image;
                }
            }

            return $images;
        } catch (\Exception $exception) {
            return [];
        }
    }
}