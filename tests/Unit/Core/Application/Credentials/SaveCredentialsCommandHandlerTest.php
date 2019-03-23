<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Application\Credentials;

use Core\Application\Credentials\CredentialsDoNotBelongToTheUser;
use Core\Application\Credentials\InvalidExchangeForCredentials;
use Core\Application\Credentials\SaveCredentials;
use Core\Application\Credentials\SaveCredentialsCommandHandler;
use Core\Domain\Credentials\CredentialsRepository;
use Core\Domain\Exchange\ExchangeRepository;
use Tests\Unit\Core\TestCase;
use Tests\Util\Factory\CredentialsFactory;
use Tests\Util\Mock\CredentialsRepositoryMock;
use Tests\Util\Mock\ExchangeRepositoryMock;

class SaveCredentialsCommandHandlerTest extends TestCase
{
    private $credentialsRepositoryMock;

    private $exchangeRepositoryMock;

    private $handler;

    protected function setUp()
    {
        $this->exchangeRepositoryMock    = new ExchangeRepositoryMock($this->prophesize(ExchangeRepository::class));
        $this->credentialsRepositoryMock = new CredentialsRepositoryMock(
            $this->prophesize(CredentialsRepository::class)
        );

        $this->handler = new SaveCredentialsCommandHandler(
            $this->credentialsRepositoryMock->reveal(),
            $this->exchangeRepositoryMock->reveal()
        );
    }

    /**
     * @throws \Throwable
     */
    public function testSaveNewCredentials(): void
    {
        $credentials = CredentialsFactory::random();

        $this->exchangeRepositoryMock
            ->shouldExist($credentials->exchangeId(), true);

        $this->credentialsRepositoryMock
            ->shouldFindCredentialsOfId($credentials->id(), null)
            ->shouldSave($credentials);

        $this->handler->__invoke(new SaveCredentials(
            $credentials->id()->value(),
            $credentials->name()->value(),
            $credentials->exchangeId()->value(),
            $credentials->key()->value(),
            $credentials->secret()->value(),
            $credentials->userId()->value()
        ));
    }

    /**
     * @throws \Throwable
     */
    public function testUpdateCredentials(): void
    {
        $existingExchange = CredentialsFactory::random(true);

        $updatedExchange = CredentialsFactory::create(
            $existingExchange->id()->value(),
            'My credentials',
            $existingExchange->exchangeId()->value(),
            'Other-key',
            'other-secret',
            $existingExchange->userId()->value(),
            true
        );

        $this->exchangeRepositoryMock
            ->shouldExist($existingExchange->exchangeId(), true);

        $this->credentialsRepositoryMock
            ->shouldFindCredentialsOfId($existingExchange->id(), $existingExchange)
            ->shouldSave($updatedExchange);

        $this->handler->__invoke(new SaveCredentials(
            $updatedExchange->id()->value(),
            $updatedExchange->name()->value(),
            $updatedExchange->exchangeId()->value(),
            $updatedExchange->key()->value(),
            $updatedExchange->secret()->value(),
            $updatedExchange->userId()->value()
        ));
    }

    /**
     * @throws \Throwable
     */
    public function testExceptionWhenExchangeIdIsNotValid(): void
    {
        $this->expectException(InvalidExchangeForCredentials::class);
        $this->expectExceptionCode(400);

        $credentials = CredentialsFactory::random();

        $this->exchangeRepositoryMock
            ->shouldExist($credentials->exchangeId(), false);

        $this->handler->__invoke(new SaveCredentials(
            $credentials->id()->value(),
            $credentials->name()->value(),
            $credentials->exchangeId()->value(),
            $credentials->key()->value(),
            $credentials->secret()->value(),
            $credentials->userId()->value()
        ));
    }

    /**
     * @throws \Throwable
     */
    public function testExceptionWhenCredentialsDoesNotBelongToTheUser(): void
    {
        $this->expectException(CredentialsDoNotBelongToTheUser::class);
        $this->expectExceptionCode(409);

        $credentials = CredentialsFactory::random();

        $this->exchangeRepositoryMock
            ->shouldExist($credentials->exchangeId(), true);

        $this->credentialsRepositoryMock
            ->shouldFindCredentialsOfId($credentials->id(), $credentials);

        $this->handler->__invoke(new SaveCredentials(
            $credentials->id()->value(),
            $credentials->name()->value(),
            $credentials->exchangeId()->value(),
            $credentials->key()->value(),
            $credentials->secret()->value(),
            $this->uuid()
        ));
    }
}
