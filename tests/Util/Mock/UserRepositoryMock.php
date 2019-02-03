<?php
declare(strict_types=1);

namespace Tests\Util\Mock;

use Core\Domain\User\User;
use Core\Domain\User\UserId;
use Core\Domain\User\UserRepository;

/**
 * @method UserRepository reveal
 */
final class UserRepositoryMock extends Mock
{
    public function shouldReturnNewIdentity(UserId $expected): self
    {
        $this->prophecy()
            ->newIdentity()
            ->willReturn($expected)
            ->shouldBeCalledOnce();

        return $this;
    }

    public function shouldFindUserOfId(UserId $userId, ?User $expected): self
    {
        $this->prophecy()
            ->userOfId($userId)
            ->willReturn($expected)
            ->shouldBeCalledOnce();

        return $this;
    }

    public function shouldSave(User $user): self
    {
        $this->prophecy()
            ->save($user)
            ->shouldBeCalledOnce();

        return $this;
    }
}
