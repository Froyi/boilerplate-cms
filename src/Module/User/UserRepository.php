<?php
declare(strict_types = 1);

namespace Project\Module\User;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Email;
use Project\Module\GenericValueObject\Id;

class UserRepository
{
    protected const TABLE = 'user';

    protected const ORDERBY = 'userId';

    protected const ORDERKIND = 'ASC';

    /** @var  Database $database */
    protected $database;

    /**
     * UserRepository constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * @param Email $email
     *
     * @return mixed
     * @throws \RuntimeException
     */
    public function getUserByEmail(Email $email)
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('email', '=', $email->getEmail());

        return $this->database->fetch($query);
    }

    /**
     * @param Id $userId
     *
     * @return mixed
     * @throws \RuntimeException
     */
    public function getUserByUserId(Id $userId)
    {
        $query = $this->database->getNewSelectQuery(self::TABLE);
        $query->where('userId', '=', $userId->toString());

        return $this->database->fetch($query);
    }
}