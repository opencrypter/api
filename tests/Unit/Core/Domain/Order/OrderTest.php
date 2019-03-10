<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Domain\Order;

use Core\Domain\Order\OrderStepsUpdated;
use Core\Domain\Order\Step\AnExecutedStepIsImmutable;
use Core\Domain\Order\Step\Step;
use Core\Domain\Order\Step\Type;
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
            StepFactory::create(1, Type::WAIT_PRICE, $this->uuid(), 'BTCUSD', 1000),
            StepFactory::create(2, Type::BUY, $this->uuid(), 'BTCUSD', 1)
        ]);

        $steps = [
            StepFactory::create(2, Type::SELL, $this->uuid(), 'BTCUSD', 1),
            StepFactory::create(3, Type::BUY, $this->uuid(), 'BTCUSD', 1)
        ];

        $order->updateSteps($steps);

        self::assertEquals($steps, $order->steps());
        self::assertEquals(OrderStepsUpdated::create($order), $order->releaseEvents()[OrderStepsUpdated::class]);
    }

    public function stepsImmutabilityDataProvider(): array
    {
        return [
            [StepFactory::withPosition(1), [StepFactory::withPosition(1)]], // Tries to modify the current step.
            [StepFactory::withPosition(1), [StepFactory::withPosition(2)]], // Tries to remove the current step.
        ];
    }

    /**
     * @dataProvider stepsImmutabilityDataProvider
     *
     * @param Step  $currentStep
     * @param Step[] $steps
     * @throws AnExecutedStepIsImmutable
     */
    public function testStepsImmutability(Step $currentStep, array $steps): void
    {
        $this->expectException(AnExecutedStepIsImmutable::class);
        $this->expectExceptionCode(409);

        $currentStep->markAsExecuted();

        $order = OrderFactory::withSteps([$currentStep]);
        $order->updateSteps($steps);
    }

    /**
     * @throws AnExecutedStepIsImmutable
     */
    public function testExceptionNotThrownWhenNoChanges(): void
    {
        $currentStep = StepFactory::withPosition(1);
        $currentStep->markAsExecuted();

        $order = OrderFactory::withSteps([$currentStep]);
        $order->releaseEvents();

        $order->updateSteps([$currentStep]);
        self::assertEmpty($order->releaseEvents());
    }
}
