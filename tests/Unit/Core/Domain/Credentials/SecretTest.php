<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Domain\Credentials;

use Core\Domain\Credentials\InvalidSecret;
use Core\Domain\Credentials\Secret;
use Tests\Unit\Core\TestCase;

class SecretTest extends TestCase
{
    /**
     * @throws InvalidSecret
     */
    public function testExceptionWhenValueIsInvalid(): void
    {
        $this->expectException(InvalidSecret::class);
        $this->expectExceptionCode(400);
        new Secret('');
    }
}
