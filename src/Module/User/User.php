<?php declare(strict_types=1);

namespace Project\Module\User;

use Project\Module\GenericValueObject\Email;
use Project\Module\GenericValueObject\Id;
use Project\Module\GenericValueObject\Password;
use Project\Module\GenericValueObject\PasswordHash;

/**
 * Class User
 * @package     Project\Module\User
 */
class User
{
    /** @var Id $userId */
    protected $userId;

    /** @var Email $email */
    protected $email;

    /** @var PasswordHash $passwordHash */
    protected $passwordHash;

    /** @var  bool $isLoggedIn */
    protected $isLoggedIn;

    /** @var Role $role */
    protected $role;

    /**
     * User constructor.
     *
     * @param Id           $userId
     * @param Email        $email
     * @param PasswordHash $passwordHash
     * @param Role         $role
     */
    public function __construct(Id $userId, Email $email, PasswordHash $passwordHash, Role $role)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->role = $role;
        $this->isLoggedIn = false;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * @param Password $password
     *
     * @return bool
     */
    public function loginUser(Password $password): bool
    {
        if ($this->passwordHash->verifyPassword($password) === true) {
            $this->loginSuccessUser();

            return true;
        }

        $this->logoutUser();

        return false;
    }

    /**
     * @return bool
     */
    public function loginUserBySession(): bool
    {
        if (isset($_SESSION['userId']) && $_SESSION['userId'] === $this->userId->toString()) {
            $this->loginSuccessUser();

            return true;
        }

        $this->logoutUser();

        return false;
    }

    /**
     * @return bool
     */
    public function logout(): bool
    {
        return $this->logoutUser();
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return ($this->role->getRole() === Role::ROLE_ADMIN);
    }

    /**
     *
     */
    protected function loginSuccessUser(): void
    {
        $this->isLoggedIn = true;
        $_SESSION['userId'] = $this->userId->toString();
    }

    /**
     * @return bool
     */
    protected function logoutUser(): bool
    {
        $this->isLoggedIn = false;

        if ($_SESSION !== null) {
            unset($_SESSION['userId']);
        }

        return true;
    }
}