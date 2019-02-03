<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Repository;

use Core\Domain\User\Email;
use Core\Domain\User\User;
use Core\Domain\User\UserId;
use Core\Domain\User\UserRepository;

class DoctrineUserRepository extends DoctrineRepository implements UserRepository
{

    protected function entityClassName(): string
    {
        return User::class;
    }

    public function newIdentity(): UserId
    {
        return new UserId($this->newGuid());
    }

    public function userOfEmail(Email $email) : ?User
    {
        return $this->repository()
            ->createQueryBuilder('user')
            ->innerJoin('user.credentials', 'credentials')
            ->where('credentials.email = :email')
            ->setParameter('email', $email->value())
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save(User $user): void
    {
        $this->persistAndFlush($user);
    }
}
