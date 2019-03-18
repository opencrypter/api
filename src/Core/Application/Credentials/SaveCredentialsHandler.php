<?php
declare(strict_types=1);

namespace Core\Application\Credentials;

use Core\Domain\Credentials\Credentials;
use Core\Domain\Credentials\CredentialsId;
use Core\Domain\Credentials\CredentialsRepository;
use Core\Domain\Credentials\Key;
use Core\Domain\Credentials\Secret;
use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Exchange\ExchangeRepository;
use Core\Domain\Name;
use Core\Domain\User\UserId;

class SaveCredentialsHandler
{
    /**
     * @var CredentialsRepository
     */
    private $repository;

    /**
     * @var ExchangeRepository
     */
    private $exchangeRepository;

    public function __construct(
        CredentialsRepository $repository,
        ExchangeRepository $exchangeRepository
    ) {
        $this->repository         = $repository;
        $this->exchangeRepository = $exchangeRepository;
    }

    /**
     * @param SaveCredentials $command
     * @throws InvalidExchangeForCredentials
     * @throws \Core\Domain\Credentials\InvalidKey
     * @throws \Core\Domain\Credentials\InvalidSecret
     * @throws \Core\Domain\Exchange\InvalidName
     */
    public function __invoke(SaveCredentials $command)
    {
        $id         = new CredentialsId($command->id());
        $name       = new Name($command->name());
        $exchangeId = new ExchangeId($command->exchangeId());
        $key        = new Key($command->key());
        $secret     = new Secret($command->secret());
        $userId     = new UserId($command->userId());

        if (!$this->exchangeRepository->exists($exchangeId)) {
            throw new InvalidExchangeForCredentials($exchangeId);
        }

        $credentials = $this->repository->credentialsOfId($id);

        if ($credentials !== null) {
            $this->guard($credentials, $userId, $id);

            $credentials->update($name, $exchangeId, $key, $secret);
        }

        $credentials = $credentials ?? new Credentials($id, $name, $exchangeId, $key, $secret, $userId);

        $this->repository->save($credentials);
    }

    /**
     * @param Credentials|null $credentials
     * @param UserId           $userId
     * @param CredentialsId    $id
     */
    private function guard(Credentials $credentials, UserId $userId, CredentialsId $id): void
    {
        if (!$credentials->userId()->equals($userId)) {
            throw new CredentialsDoesNotBelongToTheUser($id, $userId);
        }
    }
}
