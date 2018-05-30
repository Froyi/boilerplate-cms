<?php
declare(strict_types=1);

namespace Project\Module\News;

use Project\Module\GenericValueObject\Datetime;
use Project\Module\GenericValueObject\DatetimeInterface;
use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Text;
use Project\Module\GenericValueObject\Title;
use Project\Module\User\User;

/**
 * Class NewsFactory
 * @package     Project\Module\News
 */
class NewsFactory
{
    /**
     * @param      $object
     * @param User $user
     *
     * @return News
     * @throws \InvalidArgumentException
     */
    public function getNewsFromObject($object, User $user): News
    {
        /** @var Id $newsId */
        $newsId = Id::fromString($object->newsId);
        /** @var Title $title */
        $title = Title::fromString($object->title);
        /** @var Text $text */
        $text = Text::fromString($object->text);
        /** @var DatetimeInterface $created */
        $created = Datetime::fromValue($object->created);

        return new News($newsId, $title, $text, $created, $user);
    }
}