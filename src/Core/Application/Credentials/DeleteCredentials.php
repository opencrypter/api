<?php
declare(strict_types=1);

namespace Core\Application\Credentials;

class DeleteCredentials
{
    /**
     * @var string
     */
    private $credentialsId;

    /**
     * @var string
     */
    private $userId;

    /**
     * DeleteCredentials constructor.
     *
     * @param string $credentialsId
     * @param string $userId
     */
    public function __construct(string $credentialsId, string $userId)
    {
        $this->credentialsId = $credentialsId;
        $this->userId        = $userId;
    }

    /**
     * @return string
     */
    public function credentialsId(): string
    {
        return $this->credentialsId;
    }

    /**
     * @return string
     */
    public function userId(): string
    {
        return $this->userId;
    }
}
