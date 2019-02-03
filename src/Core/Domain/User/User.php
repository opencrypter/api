<?php
declare(strict_types=1);

namespace Core\Domain\User;

use Core\Domain\CreatedAt;
use Core\Domain\UpdatedAt;

class User
{
    /**
     * @var UserId
     */
    private $id;

    /**
     * @var Credentials
     */
    private $credentials;

    /**
     * @var CreatedAt
     */
    private $createdAt;

    /**
     * @var UpdatedAt|null
     */
    private $updatedAt;

    /**
     * User constructor.
     *
     * @param UserId             $id
     * @param Credentials        $credentials
     */
    public function __construct(
        UserId $id,
        Credentials $credentials
    ) {
        $this->id          = $id;
        $this->credentials = $credentials;
        $this->createdAt   = CreatedAt::now();
    }

    /**
     * @return UserId
     */
    public function id(): UserId
    {
        return $this->id;
    }

    /**
     * @return Credentials
     */
    public function credentials(): Credentials
    {
        return $this->credentials;
    }
}
