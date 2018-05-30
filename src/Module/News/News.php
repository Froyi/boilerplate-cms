<?php
declare(strict_types=1);

namespace Project\Module\News;

use Project\Module\GenericValueObject\DateInterface;
use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Text;
use Project\Module\GenericValueObject\Title;
use Project\Module\User\User;

/**
 * Class News
 * @package     Project\Module\News
 */
class News
{
    /** @var Id $newsId */
    protected $newsId;

    /** @var Title $title */
    protected $title;

    /** @var  Text $text */
    protected $text;

    /** @var  DateInterface $created */
    protected $created;

    /** @var User $user */
    protected $user;

    /**
     * News constructor.
     *
     * @param Id            $id
     * @param Title         $title
     * @param Text          $text
     * @param DateInterface $created
     * @param User          $user
     */
    public function __construct(Id $id, Title $title, Text $text, DateInterface $created, User $user)
    {
        $this->newsId = $id;
        $this->title = $title;
        $this->created = $created;
        $this->text = $text;
        $this->user = $user;
    }

    /**
     * @return DateInterface
     */
    public function getCreated(): DateInterface
    {
        return $this->created;
    }

    /**
     * @return Id
     */
    public function getNewsId(): Id
    {
        return $this->newsId;
    }

    /**
     * @return Title
     */
    public function getTitle(): Title
    {
        return $this->title;
    }

    /**
     * @return Text
     */
    public function getText(): Text
    {
        return $this->text;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}