<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Domain\Credentials;

use Core\Domain\Credentials\InvalidKey;
use Core\Domain\Credentials\Key;
use Tests\Unit\Core\TestCase;

class KeyTest extends TestCase
{
    /**
     * @throws InvalidKey
     */
    public function testExceptionWhenValueIsInvalid(): void
    {
        $this->expectException(InvalidKey::class);
        $this->expectExceptionCode(400);
        new Key('');
    }
}
