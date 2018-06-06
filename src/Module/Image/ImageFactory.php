<?php declare(strict_types=1);

namespace Project\Module\Image;

use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Title;

/**
 * Class ImageFactory
 * @package     Project\Module\Image
 */
class ImageFactory
{
    /**
     * @param $object
     *
     * @return null|Image
     */
    public function getImageFromObject($object): ?Image
    {
        try {
            $imageId = Id::fromString($object->imageId);
            $imageUrl = $object->imageUrl;
            $galeryId = Id::fromString($object->galeryId);

            $image = new Image($imageId, $imageUrl, $galeryId);

            if (isset($object->title) && empty($object->title) === false) {
                $image->setTitle(Title::fromString($object->title));
            }

            return $image;
        } catch (\Exception $exception) {
            return null;
        }
    }
}