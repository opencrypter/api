<?php
declare(strict_types=1);

namespace Core\Domain\User;

interface UserFactory
{
    public function create(UserId $userId, Email $email, PlainPassword $plainPassword): User;
}
