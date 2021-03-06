<?php
declare(strict_types=1);

namespace Core\Application\Credentials;

class GetCredentialsDetail
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $userId;

    /**
     * GetCredentialsDetail constructor.
     *
     * @param string $id
     * @param string $userId
     */
    public function __construct(string $id, string $userId)
    {
        $this->id     = $id;
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function userId(): string
    {
        return $this->userId;
    }
}
