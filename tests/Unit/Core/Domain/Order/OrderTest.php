<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Domain\Order;

use Core\Domain\Order\Step\AnExecutedStepIsImmutable;
use Tests\Unit\Core\TestCase;
use Tests\Util\Factory\OrderFactory;
use Tests\Util\Factory\StepFactory;

class OrderTest extends TestCase
{
    /**
     * @throws AnExecutedStepIsImmutable
     */
    public function testUpdateSteps(): void
    {
        $order = OrderFactory::withSteps([
            StepFactory::create(1, 'wait_price', $this->uuid(), 'BTCUSD', 4500, null),
            StepFactory::create(2, 'sell', $this->uuid(), 'BTCUSD', 400, null),
        ]);

        $newStep = StepFactory::create(1, 'buy', $this->uuid(), 'BTCUSD', 100, null);

        $order->updateSteps([$newStep]);

        self::assertEquals([$newStep], $order->steps());
    }

    /**
     * @throws AnExecutedStepIsImmutable
     */
    public function testExceptionWhenTryToRemoveAnExecutedStep(): void
    {
        $this->expectException(AnExecutedStepIsImmutable::class);

        $existingStep = StepFactory::random();
        $existingStep->markAsExecuted();

        $order = OrderFactory::create($this->faker()->uuid, $this->faker()->uuid, [$existingStep]);
        $order->updateSteps([StepFactory::random()]);
    }
}
