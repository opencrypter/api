<?php
declare(strict_types=1);

namespace Core\Domain\Credentials;

interface CredentialsRepository
{
    public function save(Credentials $credentials): void;

    public function delete(Credentials $credentials): void;

    public function credentialsOfId(CredentialsId $id): ?Credentials;
}
