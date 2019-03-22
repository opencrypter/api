<?php
declare(strict_types=1);

namespace Core\Domain\Credentials;

use Core\Domain\User\UserId;

interface CredentialsRepository
{
    public function save(Credentials $credentials): void;

    public function delete(Credentials $credentials): void;

    public function credentialsOfId(CredentialsId $id): ?Credentials;

    public function allOfUserId(UserId $userId): array;
}
