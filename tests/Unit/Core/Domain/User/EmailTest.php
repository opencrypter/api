<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Domain\User;

use Core\Domain\User\Email;
use Core\Domain\User\InvalidEmail;
use Tests\Unit\Core\TestCase;

class EmailTest extends TestCase
{
    public function invalidValueDataProvider(): array
    {
        return [
            [''],
            ['email'],
            ['email@'],
            ['email@example'],
            ['email@example.'],
        ];
    }

    /**
     * @dataProvider invalidValueDataProvider
     * @param string $email
     */
    public function testExceptionWhenValueIsInvalid(string $email): void
    {
        $this->expectException(InvalidEmail::class);
        $this->expectExceptionCode(400);
        new Email($email);
    }
}
