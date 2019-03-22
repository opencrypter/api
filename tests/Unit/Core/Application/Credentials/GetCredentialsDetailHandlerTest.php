<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Application\Credentials;

use Core\Application\Credentials\CredentialsDtoAssembler;
use Core\Application\Credentials\CredentialsNotFound;
use Core\Application\Credentials\GetCredentialsDetail;
use Core\Application\Credentials\GetCredentialsDetailHandler;
use Core\Domain\Credentials\CredentialsRepository;
use Tests\Unit\Core\TestCase;
use Tests\Util\Factory\CredentialsFactory;
use Tests\Util\Mock\CredentialsRepositoryMock;

class GetCredentialsDetailHandlerTest extends TestCase
{
    private $repositoryMock;

    private $dtoAssembler;

    private $handler;

    protected function setUp()
    {
        $this->repositoryMock = new CredentialsRepositoryMock($this->prophesize(CredentialsRepository::class));
        $this->dtoAssembler   = new CredentialsDtoAssembler();

        $this->handler = new GetCredentialsDetailHandler(
            $this->repositoryMock->reveal(),
            $this->dtoAssembler
        );
    }

    public function testHandler(): void
    {
        $credentials = CredentialsFactory::random();

        $this->repositoryMock->shouldFindCredentialsOfId($credentials->id(), $credentials);

        $result = $this->handler->__invoke(new GetCredentialsDetail($credentials->id()->value()));

        self::assertEquals($this->dtoAssembler->writeDto($credentials), $result);
    }

    public function testExceptionWhenCredentialsDontExist(): void
    {
        $this->expectException(CredentialsNotFound::class);
        $this->expectExceptionCode(404);

        $credentials = CredentialsFactory::random();

        $this->repositoryMock->shouldFindCredentialsOfId($credentials->id(), null);

        $this->handler->__invoke(new GetCredentialsDetail($credentials->id()->value()));
    }
}
