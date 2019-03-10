<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Domain\User;

use Core\Domain\User\InvalidPassword;
use Core\Domain\User\PlainPassword;
use Tests\Unit\Core\TestCase;

class PlainPasswordTest extends TestCase
{
    public function testValue(): void
    {
        self::assertEquals('123456', (new PlainPassword('123456'))->value());
    }

    public function testExceptionWhenValueIsInvalid(): void
    {
        $this->expectException(InvalidPassword::class);
        $this->expectExceptionCode(400);

        new PlainPassword('12345');
    }
}
