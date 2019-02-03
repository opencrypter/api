<?php
declare(strict_types=1);

namespace Core\Infrastructure\Security;

use Core\Domain\User\Credentials;
use Doctrine\ORM\Mapping as ORM;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;

/**
 * Class User
 *
 * @ORM\Entity
 * @ORM\Table(name="user_credentials")
 */
class UserCredentials implements Credentials, JWTUserInterface
{
    public const ROLE_USER = 'ROLE_USER';

    public const DEFAULT_CREDENTIALS = [
        self::ROLE_USER,
    ];

    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var array
     * @ORM\Column(type="json")
     */
    private $roles;

    /**
     * UserCredentials constructor.
     *
     * @param string      $userId
     * @param string      $email
     * @param string|null $password
     * @param array       $roles
     */
    public function __construct(
        string $userId,
        string $email,
        ?string $password = null,
        array $roles = self::DEFAULT_CREDENTIALS
    ) {
        $this->id       = $userId;
        $this->email    = $email;
        $this->password = $password;
        $this->roles    = $roles;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
    }

    public function email(): string
    {
        return $this->email;
    }

    /**
     * Creates a new instance from a given JWT payload.
     *
     * @param string $username
     * @param array  $payload
     *
     * @return JWTUserInterface
     */
    public static function createFromPayload($username, array $payload)
    {
        return new self(
            $payload['id'],
            $username,
            '',
            $payload['roles']
        );
    }
}
