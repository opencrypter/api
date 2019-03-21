<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Application\Credentials;

use Core\Application\Credentials\CredentialsDoesNotBelongToTheUser;
use Core\Application\Credentials\CredentialsNotFound;
use Core\Application\Credentials\DeleteCredentials;
use Core\Application\Credentials\DeleteCredentialsHandler;
use Core\Domain\Credentials\CredentialsRepository;
use Tests\Unit\Core\TestCase;
use Tests\Util\Factory\CredentialsFactory;
use Tests\Util\Mock\CredentialsRepositoryMock;

class DeleteCredentialsHandlerTest extends TestCase
{
    private $credentialsRepositoryMock;

    private $handler;

    protected function setUp()
    {
        $this->credentialsRepositoryMock = new CredentialsRepositoryMock(
            $this->prophesize(CredentialsRepository::class)
        );

        $this->handler = new DeleteCredentialsHandler(
            $this->credentialsRepositoryMock->reveal()
        );
    }

    /**
     * @throws \Throwable
     */
    public function testDeleteCredentials(): void
    {
        $credentials = CredentialsFactory::random();

        $this->credentialsRepositoryMock
            ->shouldFindCredentialsOfId($credentials->id(), $credentials)
            ->shouldDelete($credentials);

        $this->handler->__invoke(new DeleteCredentials(
            $credentials->id()->value(),
            $credentials->userId()->value()
        ));
    }

    /**
     * @throws \Throwable
     */
    public function testExceptionWhenCredentialsDontExist(): void
    {
        $this->expectException(CredentialsNotFound::class);
        $this->expectExceptionCode(404);

        $credentials = CredentialsFactory::random();

        $this->credentialsRepositoryMock
            ->shouldFindCredentialsOfId($credentials->id(), null);

        $this->handler->__invoke(new DeleteCredentials(
            $credentials->id()->value(),
            $credentials->userId()->value()
        ));
    }

    /**
     * @throws \Throwable
     */
    public function testExceptionWhenCredentialsDoesNotBelongToTheUser(): void
    {
        $this->expectException(CredentialsDoesNotBelongToTheUser::class);
        $this->expectExceptionCode(409);

        $credentials = CredentialsFactory::random();

        $this->credentialsRepositoryMock
            ->shouldFindCredentialsOfId($credentials->id(), $credentials);

        $this->handler->__invoke(new DeleteCredentials(
            $credentials->id()->value(),
            $this->uuid()
        ));
    }
}
