<?php
declare(strict_types=1);

namespace Core\Application\Credentials;

use Core\Domain\Credentials\Credentials;

class CredentialsDtoAssembler
{
    /**
     * @param Credentials $credentials
     * @return CredentialsDto
     */
    public function writeDto(Credentials $credentials): CredentialsDto
    {
        return new CredentialsDto(
            $credentials->id()->value(),
            $credentials->name()->value(),
            $credentials->exchangeId()->value(),
            $credentials->key()->value(),
            $credentials->secret()->value()
        );
    }
}
