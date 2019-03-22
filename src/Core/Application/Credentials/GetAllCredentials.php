<?php
declare(strict_types=1);

namespace Core\Application\Credentials;

class GetAllCredentials
{
    /**
     * @var string
     */
    private $userId;

    /**
     * GetAllCredentials constructor.
     *
     * @param string $userId
     */
    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function userId(): string
    {
        return $this->userId;
    }
}
