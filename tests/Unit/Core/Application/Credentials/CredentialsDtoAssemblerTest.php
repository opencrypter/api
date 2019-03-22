<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Application\Credentials;

use Core\Application\Credentials\CredentialsDto;
use Core\Application\Credentials\CredentialsDtoAssembler;
use Tests\Unit\Core\TestCase;
use Tests\Util\Factory\CredentialsFactory;

class CredentialsDtoAssemblerTest extends TestCase
{
    public function testWrite(): void
    {
        $credentials = CredentialsFactory::random();

        $expected = new CredentialsDto(
            $credentials->id()->value(),
            $credentials->name()->value(),
            $credentials->exchangeId()->value(),
            $credentials->key()->value(),
            $credentials->secret()->value()
        );

        self::assertEquals($expected, (new CredentialsDtoAssembler)->writeDto($credentials));
    }
}
