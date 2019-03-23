<?php
declare(strict_types=1);

namespace Core\Application\User;

use Core\Domain\User\Email;
use Core\Domain\User\PlainPassword;
use Core\Domain\User\UserFactory;
use Core\Domain\User\UserRepository;

class CreateUserCommandHandler
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var UserFactory
     */
    private $userFactory;

    public function __construct(UserRepository $repository, UserFactory $credentialsFactory)
    {
        $this->repository  = $repository;
        $this->userFactory = $credentialsFactory;
    }

    /**
     * @param CreateUser $command
     * @throws \Core\Domain\User\InvalidPassword
     * @throws \Core\Domain\User\InvalidEmail
     * @throws DuplicatedUser
     */
    public function __invoke(CreateUser $command): void
    {
        $email    = new Email($command->username());
        $password = new PlainPassword($command->password());

        if ($this->repository->userOfEmail($email)) {
            throw new DuplicatedUser($email);
        }
        $user = $this->userFactory->create($this->repository->newIdentity(), $email, $password);

        $this->repository->save($user);
    }
}
