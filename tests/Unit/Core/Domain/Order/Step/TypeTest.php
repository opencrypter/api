<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Domain\Order\Step;

use Core\Domain\Order\Step\InvalidType;
use Core\Domain\Order\Step\Type;
use Tests\Unit\Core\TestCase;

class TypeTest extends TestCase
{
    /**
     * @throws InvalidType
     */
    public function testExceptionWhenValueIsInvalid(): void
    {
        $this->expectException(InvalidType::class);
        $this->expectExceptionCode(400);

        new Type('not-supported');
    }
}
