<?php
declare(strict_types=1);

namespace Project\Module\User;

use Project\Module\GenericValueObject\Email;
use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Password;
use Project\Module\GenericValueObject\PasswordHash;

class UserFactory
{
    /**
     * @param          $object
     * @param Password $password
     *
     * @return null|User
     * @throws \InvalidArgumentException
     */
    public function getLoggedInUserByPassword($object, Password $password): ?User
    {
        $user = $this->getUser($object);

        if ($user->loginUser($password) === false) {
            return null;
        }

        return $user;
    }

    /**
     * @param $object
     *
     * @return null|User
     * @throws \InvalidArgumentException
     */
    public function getLoggedInUserByUserId($object): ?User
    {
        $user = $this->getUser($object);

        if ($user->loginUserBySession() === false) {
            return null;
        }

        return $user;
    }

    /**
     * @param $object
     *
     * @return User
     * @throws \InvalidArgumentException
     */
    public function getUser($object): User
    {
        $userId = Id::fromString($object->userId);

        $email = Email::fromString($object->email);

        $roleString = null;
        if (empty($object->role) === false) {
            $roleString = $object->role;
        }
        $role = Role::fromString($roleString);

        $passwordHash = PasswordHash::fromString($object->passwordHash);

        return new User($userId, $email, $passwordHash, $role);
    }
}