<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Domain\Order\Step;

use Core\Domain\Order\Step\InvalidPosition;
use Core\Domain\Order\Step\Position;
use Tests\Unit\Core\TestCase;

class PositionTest extends TestCase
{
    /**
     * @throws InvalidPosition
     */
    public function testExceptionWhenValueIsInvalid(): void
    {
        $this->expectException(InvalidPosition::class);
        $this->expectExceptionCode(400);

        new Position(0);
    }
}
