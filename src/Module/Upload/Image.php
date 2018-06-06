<?php
declare (strict_types=1);

namespace Project\Module\Upload;

use claviska\SimpleImage;
use Project\Module\DefaultModel;

/**
 * Class Image
 * @package Project\Module\Image
 */
class Image extends DefaultModel
{
    /** @var int SAVE_QUALITY */
    protected const SAVE_QUALITY = 50;

    /** @var int MAX_LENGTH */
    protected const MAX_LENGTH = 1200;

    /** @var bool AUTO_ORIENTATION */
    protected const AUTO_ORIENTATION = false;

    /** @var bool FIT_TO_ORIENTATION */
    protected const FIT_TO_ORIENTATION = false;

    /** @var bool SHARPEN */
    protected const SHARPEN = false;

    /** @var SimpleImage $image */
    protected $image;

    /**
     * Image constructor.
     *
     * @param string $path
     *
     * @throws \Exception
     */
    protected function __construct(string $path)
    {
        $this->image = new SimpleImage($path);

        if (self::AUTO_ORIENTATION === true) {
            $this->image->autoOrient();
        }

        if (self::FIT_TO_ORIENTATION === true) {
            if ($this->image->getAspectRatio() >= 1) {
                $this->image->fitToWidth(self::MAX_LENGTH);
            } else {
                $this->image->fitToHeight(self::MAX_LENGTH);
            }
        }

        if (self::SHARPEN === true) {
            $this->image->sharpen();
        }
    }

    /**
     * @param string $path
     *
     * @return Image
     * @throws \Exception
     */
    public static function fromFile(string $path): self
    {
        return new self($path);
    }

    /**
     * @param string $path
     *
     * @return bool
     * @throws \Exception
     */
    public function saveToPath(string $path): bool
    {
        try {
            $this->image->toFile($path, null, self::SAVE_QUALITY);
        } catch (\InvalidArgumentException $error) {
            return false;
        }

        return true;
    }
}