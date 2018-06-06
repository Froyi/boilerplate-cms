<?php
declare (strict_types=1);

namespace Project\Module\Galery;

use Project\Module\GenericValueObject\Date;
use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Title;

/**
 * Class GaleryFactory
 * @package Project\Module\Galery
 */
class GaleryFactory
{
    /**
     * @param $object
     *
     * @return Galery
     * @throws \InvalidArgumentException
     */
    public function getGaleryFromObject($object): Galery
    {
        $galeryId = Id::fromString($object->galeryId);
        $title = Title::fromString($object->title);

        if (empty($object->galeryDate) === true) {
            $galeryDate = Date::fromNow();
        } else {
            /** @var Date $galeryDate */
            $galeryDate = Date::fromValue($object->galeryDate);
        }

        return new Galery($galeryId, $title, $galeryDate);
    }
}