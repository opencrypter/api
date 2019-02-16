<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Domain\Order;

use Core\Domain\Order\Step\AnExecutedStepCannotBeRemoved;
use Tests\Unit\Core\TestCase;
use Tests\Util\Factory\OrderFactory;
use Tests\Util\Factory\StepFactory;

class OrderTest extends TestCase
{
    /**
     * @throws AnExecutedStepCannotBeRemoved
     */
    public function testUpdateSteps(): void
    {
        $steps = [StepFactory::random(), StepFactory::random()];
        $order = OrderFactory::random();

        $order->updateSteps($steps);
        self::assertEquals($steps, $order->steps());
    }

    /**
     * @throws AnExecutedStepCannotBeRemoved
     */
    public function testExceptionWhenTryToRemoveAnExecutedStep(): void
    {
        $this->expectException(AnExecutedStepCannotBeRemoved::class);

        $existingStep = StepFactory::random();
        $existingStep->markAsExecuted();

        $order = OrderFactory::create($this->faker()->uuid, $this->faker()->uuid, [$existingStep]);
        $order->updateSteps([StepFactory::random()]);
    }
}
