<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Domain;

use Core\Domain\Exchange\InvalidName;
use Core\Domain\Name;
use Tests\Unit\Core\TestCase;

class NameTest extends TestCase
{
    /**
     * @throws InvalidName
     */
    public function testExceptionOnInvalidName(): void
    {
        $this->expectException(InvalidName::class);
        $this->expectExceptionCode(400);

        new Name('');
    }
}
