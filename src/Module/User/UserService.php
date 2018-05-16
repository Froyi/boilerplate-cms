<?php
declare(strict_types=1);

namespace Project\Module\User;

use Project\Module\Database\Database;
use Project\Module\GenericValueObject\Email;
use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Password;

class UserService
{
    /** @var  UserFactory $newsFactory */
    protected $userFactory;

    /** @var  UserRepository $userRepository */
    protected $userRepository;

    /**
     * UserService constructor.
     *
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->userFactory = new UserFactory();
        $this->userRepository = new UserRepository($database);
    }

    /**
     * @param Email    $email
     * @param Password $password
     *
     * @return null|User
     */
    public function getLoggedInUserByEmailAndPassword(Email $email, Password $password): ?User
    {
        $userResult = $this->userRepository->getUserByEmail($email);

        if (empty($userResult)) {
            return null;
        }

        return $this->userFactory->getLoggedInUserByPassword($userResult, $password);
    }


    /**
     * @param Id $userId
     *
     * @return null|User
     */
    public function getLoggedInUserByUserId(Id $userId): ?User
    {
        $userResult = $this->userRepository->getUserByUserId($userId);

        if (empty($userResult)) {
            return null;
        }

        return $this->userFactory->getLoggedInUserByUserId($userResult);
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function logoutUser(User $user): bool
    {

        return $user->logout();
    }

    /**
     * @param Id $userId
     *
     * @return null|User
     */
    public function getUserByUserId(Id $userId): ?User
    {
        $userResult = $this->userRepository->getUserByUserId($userId);

        if (empty($userResult)) {
            return null;
        }

        return $this->userFactory->getUser($userResult);
    }
}