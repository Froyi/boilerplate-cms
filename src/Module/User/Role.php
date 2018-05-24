<?php declare(strict_types=1);

namespace Project\Module\User;

/**
 * Class Role
 * @package     Project\Module\User
 */
class Role
{
    public const ROLE_ADMIN = 'Admin';
    public const ROLE_MEMBER = 'Member';

    /** @var array VALID_ROLES */
    protected const VALID_ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_MEMBER
    ];

    protected const DEFAULT_ROLE = self::ROLE_ADMIN;

    /** @var string $role */
    protected $role;

    /**
     * Role constructor.
     *
     * @param string $role
     */
    protected function __construct(string $role)
    {
        $this->role = $role;
    }

    /**
     * @param null|string $role
     *
     * @return Role
     * @throws \InvalidArgumentException
     */
    public static function fromString(string $role = null): self
    {
        if ($role === null) {
            return new self(self::DEFAULT_ROLE);
        }

        self::ensureRoleIsValid($role);

        return new self($role);
    }

    /**
     * @param string $role
     *
     * @throws \InvalidArgumentException
     */
    protected static function ensureRoleIsValid(string $role): void
    {
        if (\in_array($role, self::VALID_ROLES, true) === false) {
            throw new \InvalidArgumentException('This role is not valid ' . $role);
        }
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getRole();
    }
}