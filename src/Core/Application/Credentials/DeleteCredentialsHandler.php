<?php
declare(strict_types=1);

namespace Core\Application\Credentials;

use Core\Domain\Credentials\CredentialsId;
use Core\Domain\Credentials\CredentialsRepository;
use Core\Domain\User\UserId;

class DeleteCredentialsHandler
{
    /**
     * @var CredentialsRepository
     */
    private $repository;

    /**
     * DeleteCredentialsHandler constructor.
     *
     * @param CredentialsRepository $repository
     */
    public function __construct(CredentialsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param DeleteCredentials $command
     */
    public function __invoke(DeleteCredentials $command): void
    {
        $id     = new CredentialsId($command->credentialsId());
        $userId = new UserId($command->userId());

        $credentials = $this->repository->credentialsOfId($id);

        if ($credentials === null) {
            throw new CredentialsNotFound($id);
        }

        if (!$credentials->userId()->equals($userId)) {
            throw new CredentialsDoesNotBelongToTheUser($id, $userId);
        }

        $this->repository->delete($credentials);
    }
}
