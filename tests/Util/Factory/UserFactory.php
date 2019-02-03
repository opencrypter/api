<?php
declare(strict_types=1);

namespace Tests\Util\Factory;

use Core\Domain\User\User;
use Core\Domain\User\UserId;
use Core\Infrastructure\Security\UserCredentials;

class UserFactory
{
    public static function create(string $id, string $email, string $password): User
    {
        return new User(
            new UserId($id),
            new UserCredentials($id, $email, $password)
        );
    }
}
