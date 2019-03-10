<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Domain\Order\Step;

use Core\Domain\Order\Step\Step;
use Core\Domain\Order\Step\Type;
use Tests\Unit\Core\TestCase;
use Tests\Util\Factory\StepFactory;

class StepTest extends TestCase
{
    public function equalsDataProvider(): array
    {
        $exchangeId = $this->uuid();

        return [
            [
                StepFactory::create(2, Type::SELL, $exchangeId, 'BTCUSD', 1, 1),
                StepFactory::create(2, Type::SELL, $exchangeId, 'BTCUSD', 1, 1),
                true,
            ],
            [
                StepFactory::create(1, Type::SELL, $exchangeId, 'BTCUSD', 1, 1),
                StepFactory::create(2, Type::SELL, $exchangeId, 'BTCUSD', 1, 1),
                false,
            ],
            [
                StepFactory::create(2, Type::BUY, $exchangeId, 'BTCUSD', 1, 1),
                StepFactory::create(2, Type::SELL, $exchangeId, 'BTCUSD', 1, 1),
                false,
            ],
            [
                StepFactory::create(2, Type::SELL, $this->uuid(), 'ETHUSD', 1, 1),
                StepFactory::create(2, Type::SELL, $exchangeId, 'BTCUSD', 1, 1),
                false,
            ],
            [
                StepFactory::create(2, Type::SELL, $exchangeId, 'BTCUSD', 2, 1),
                StepFactory::create(2, Type::SELL, $exchangeId, 'BTCUSD', 1, 1),
                false,
            ],
            [
                StepFactory::create(2, Type::SELL, $exchangeId, 'BTCUSD', 1, null),
                StepFactory::create(2, Type::SELL, $exchangeId, 'BTCUSD', 1, 1),
                false,
            ],
        ];
    }

    /**
     * @dataProvider equalsDataProvider
     *
     * @param Step $stepA
     * @param Step $stepB
     * @param bool $expected
     */
    public function testEquals(Step $stepA, Step $stepB, bool $expected): void
    {
        self::assertEquals($expected, $stepA->equals($stepB));
    }
}
