<?php
declare(strict_types=1);

namespace Core\Application\Order;

use Core\Domain\Order\Order;
use Core\Domain\Order\Step\Step;

class OrderDtoAssembler
{
    /**
     * @param Order $order
     * @return OrderDto
     */
    public function writeDto(Order $order): OrderDto
    {
        $steps = $this->writeStepDtos($order);

        return new OrderDto($order->id()->value(), $steps);
    }

    /**
     * @param Order $order
     * @return StepDto[]
     */
    private function writeStepDtos(Order $order): array
    {
        return array_map(function (Step $step) {
            return new StepDto(
                $step->position()->value(),
                $step->type()->value(),
                $step->exchangeId()->value(),
                $step->symbol()->value(),
                $step->value()->value(),
                $step->dependsOf() !== null ? $step->dependsOf()->value() : null
            );
        }, $order->steps());
    }
}
