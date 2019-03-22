<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Application\Credentials;

use Core\Application\Credentials\CredentialsDtoAssembler;
use Core\Application\Credentials\GetAllCredentials;
use Core\Application\Credentials\GetAllCredentialsHandler;
use Core\Domain\Credentials\CredentialsRepository;
use Tests\Unit\Core\TestCase;
use Tests\Util\Factory\CredentialsFactory;
use Tests\Util\Mock\CredentialsRepositoryMock;

class GetAllCredentialsHandlerTest extends TestCase
{
    private $repositoryMock;

    private $dtoAssembler;

    private $handler;

    protected function setUp()
    {
        $this->repositoryMock = new CredentialsRepositoryMock($this->prophesize(CredentialsRepository::class));
        $this->dtoAssembler   = new CredentialsDtoAssembler();

        $this->handler = new GetAllCredentialsHandler(
            $this->repositoryMock->reveal(),
            $this->dtoAssembler
        );
    }

    public function testHandler(): void
    {
        $credentials = CredentialsFactory::random();

        $this->repositoryMock->shouldFindAllOfUserId($credentials->userId(), [$credentials]);

        $result = $this->handler->__invoke(new GetAllCredentials($credentials->userId()->value()));

        self::assertEquals([$this->dtoAssembler->writeDto($credentials)], $result);
    }
}
