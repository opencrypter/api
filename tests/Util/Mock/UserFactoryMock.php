<?php
declare(strict_types=1);

namespace Tests\Util\Mock;

use Core\Domain\User\Email;
use Core\Domain\User\PlainPassword;
use Core\Domain\User\User;
use Core\Domain\User\UserId;

class UserFactoryMock extends Mock
{
    public function shouldCreate(string $id, string $email, string $password, User $expected): self
    {
        $this->prophecy()
            ->create(new UserId($id), new Email($email), new PlainPassword($password))
            ->willReturn($expected)
            ->shouldBeCalledOnce();

        return $this;
    }
}
