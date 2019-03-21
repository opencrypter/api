<?php
declare(strict_types=1);

namespace Tests\Util\Mock;

use Core\Domain\Credentials\Credentials;
use Core\Domain\Credentials\CredentialsId;
use Core\Domain\Credentials\CredentialsRepository;

/**
 * @method CredentialsRepository reveal
 */
final class CredentialsRepositoryMock extends Mock
{
    public function shouldFindCredentialsOfId(CredentialsId $exchangeId, ?Credentials $expected): self
    {
        $this->prophecy()
            ->credentialsOfId($exchangeId)
            ->willReturn($expected)
            ->shouldBeCalledOnce();

        return $this;
    }

    public function shouldSave(Credentials $credentials): self
    {
        $this->prophecy()
            ->save($credentials)
            ->shouldBeCalledOnce();

        return $this;
    }

    public function shouldDelete(Credentials $credentials): self
    {
        $this->prophecy()
            ->delete($credentials)
            ->shouldBeCalledOnce();

        return $this;
    }
}
