<?php declare(strict_types=1);

namespace Project\Module\Upload;

use Project\Module\GenericValueObject\Filename;

/**
 * Class UploadService
 * @package     Project\Module\Upload
 */
class UploadService
{
    /** @var string PATH_GALERY */
    public const PATH_GALERY = 'data/img/galery/';

    public static function uploadImage(array $uploadedFile, $path = self::PATH_GALERY): ?string
    {
        try {
            if ($image = Image::fromFile($uploadedFile['tmp_name'])) {
                $filePath = $path . Filename::generateFilename($uploadedFile['type']);

                if ($image->saveToPath($filePath) === true) {
                    return $filePath;
                }
            }

            return null;
        } catch (\Exception $exception) {
            return null;
        }
    }
}
