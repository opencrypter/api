<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Domain\Exchange;

use Core\Domain\Exchange\InvalidName;
use Core\Domain\Exchange\Name;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    /**
     * @throws InvalidName
     */
    public function testExceptionOnInvalidName(): void
    {
        $this->expectException(InvalidName::class);
        new Name('');
    }
}
