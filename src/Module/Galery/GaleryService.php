<?php
declare (strict_types=1);

namespace Project\Module\Galery;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Id;
use Project\Module\Image\ImageService;

/**
 * Class GaleryService
 * @package Project\Module\Galery
 */
class GaleryService
{
    /** @var  GaleryFactory $galeryFactory */
    protected $galeryFactory;

    /** @var  GaleryRepository $galeryRepository */
    protected $galeryRepository;

    /**
     * GaleryService constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->galeryFactory = new GaleryFactory();
        $this->galeryRepository = new GaleryRepository($database);
    }

    /**
     * @param ImageService $imageService
     *
     * @return array
     */
    public function getAllGaleries(ImageService $imageService): array
    {
        try {
            $galeries = [];

            $galeryResult = $this->galeryRepository->getAllGaleries();

            if (\count($galeryResult) === 0) {
                return $galeries;
            }

            foreach ($galeryResult as $galery) {
                /** @var Galery $galery */
                $galery = $this->galeryFactory->getGaleryFromObject($galery);

                $images = $imageService->getImagesByGaleryId($galery->getGaleryId());

                foreach ($images as $image) {
                    $galery->addImageToImageList($image);
                }

                $galeries[$galery->getGaleryId()->toString()] = $galery;
            }

            return $galeries;
        } catch (\Exception $exception) {
            return [];
        }
    }

    /**
     * @param $galeryId
     *
     * @return null|Galery
     */
    public function getGaleryByGaleryId($galeryId): ?Galery
    {
        try {
            if ($galeryId instanceof Id === false) {
                $galeryId = Id::fromString($galeryId);
            }

            $galery = $this->galeryRepository->getGaleryByGaleryId($galeryId);

            if (empty($galery)) {
                return null;
            }

            return $this->galeryFactory->getGaleryFromObject($galery);
        } catch (\InvalidArgumentException | \RuntimeException $exception) {
            return null;
        }
    }

    /**
     * @param array $parameter
     *
     * @return Galery
     */
    public function getGaleryByParameter(array $parameter): ?Galery
    {
        try {
            $objectParameter = (object)$parameter;

            if (!isset($objectParameter->galeryId) || (isset($objectParameter->galeryId) && empty($objectParameter->galeryId))) {
                $objectParameter->galeryId = Id::generateId()->toString();
            }

            return $this->galeryFactory->getGaleryFromObject($objectParameter);
        } catch (\Exception $exception) {
            return null;
        }
    }

    /**
     * @param Galery $galery
     *
     * @return bool
     */
    public function saveGalery(Galery $galery): bool
    {
        try {
            return $this->galeryRepository->saveGalery($galery);
        } catch (\RuntimeException $exception) {
            return false;
        }
    }

    /**
     * @param Galery $galery
     *
     * @return bool
     * @throws \RuntimeException
     */
    public function deleteGalery(Galery $galery): bool
    {
        return $this->galeryRepository->deleteGalery($galery);
    }
}