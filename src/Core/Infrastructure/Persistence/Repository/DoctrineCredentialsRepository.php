<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Repository;

use Core\Domain\Credentials\Credentials;
use Core\Domain\Credentials\CredentialsId;
use Core\Domain\Credentials\CredentialsRepository;
use Core\Domain\User\UserId;

class DoctrineCredentialsRepository extends DoctrineRepository implements CredentialsRepository
{
    /**
     * @return string
     */
    protected function entityClassName(): string
    {
        return Credentials::class;
    }

    public function save(Credentials $credentials): void
    {
        $this->persistAndFlush($credentials);
    }

    public function delete(Credentials $credentials): void
    {
        $this->remove($credentials);
    }

    public function credentialsOfId(CredentialsId $id): ?Credentials
    {
        return $this->repository()->find($id);
    }

    public function allOfUserId(UserId $userId): array
    {
        return $this->repository()->findBy(['userId' => $userId]);
    }
}
