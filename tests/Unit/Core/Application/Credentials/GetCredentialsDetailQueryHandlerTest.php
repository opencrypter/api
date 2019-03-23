<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Application\Credentials;

use Core\Application\Credentials\CredentialsDoNotBelongToTheUser;
use Core\Application\Credentials\CredentialsDtoAssembler;
use Core\Application\Credentials\CredentialsNotFound;
use Core\Application\Credentials\GetCredentialsDetail;
use Core\Application\Credentials\GetCredentialsDetailQueryHandler;
use Core\Domain\Credentials\CredentialsRepository;
use Tests\Unit\Core\TestCase;
use Tests\Util\Factory\CredentialsFactory;
use Tests\Util\Mock\CredentialsRepositoryMock;

class GetCredentialsDetailQueryHandlerTest extends TestCase
{
    private $repositoryMock;

    private $dtoAssembler;

    private $handler;

    protected function setUp()
    {
        $this->repositoryMock = new CredentialsRepositoryMock($this->prophesize(CredentialsRepository::class));
        $this->dtoAssembler   = new CredentialsDtoAssembler();

        $this->handler = new GetCredentialsDetailQueryHandler(
            $this->repositoryMock->reveal(),
            $this->dtoAssembler
        );
    }

    public function testHandler(): void
    {
        $credentials = CredentialsFactory::random();

        $this->repositoryMock->shouldFindCredentialsOfId($credentials->id(), $credentials);

        $result = $this->handler->__invoke(new GetCredentialsDetail(
            $credentials->id()->value(),
            $credentials->userId()->value()
        ));

        self::assertEquals($this->dtoAssembler->writeDto($credentials), $result);
    }

    public function testExceptionWhenCredentialsDontExist(): void
    {
        $this->expectException(CredentialsNotFound::class);
        $this->expectExceptionCode(404);

        $credentials = CredentialsFactory::random();

        $this->repositoryMock->shouldFindCredentialsOfId($credentials->id(), null);

        $this->handler->__invoke(new GetCredentialsDetail(
            $credentials->id()->value(),
            $credentials->userId()->value()
        ));
    }

    public function testExceptionWhenCredentialsDontBelongToTheUser(): void
    {
        $this->expectException(CredentialsDoNotBelongToTheUser::class);
        $this->expectExceptionCode(409);

        $credentials = CredentialsFactory::random();

        $this->repositoryMock->shouldFindCredentialsOfId($credentials->id(), $credentials);

        $this->handler->__invoke(new GetCredentialsDetail(
            $credentials->id()->value(),
            $this->uuid()
        ));
    }
}
