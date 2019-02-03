<?php
declare(strict_types=1);

namespace Core\Domain\User;

interface UserRepository
{
    public function newIdentity(): UserId;

    public function userOfUsername(Email $email): ?User;

    public function save(User $user): void;
}
