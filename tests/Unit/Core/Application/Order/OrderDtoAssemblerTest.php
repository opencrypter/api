<?php
declare(strict_types=1);

namespace Tests\Core\Application\Exchange;

use Core\Application\Order\OrderDto;
use Core\Application\Order\OrderDtoAssembler;
use Core\Application\Order\StepDto;
use Core\Domain\Order\Step\Step;
use PHPUnit\Framework\TestCase;
use Tests\Util\Factory\OrderFactory;

class OrderDtoAssemblerTest extends TestCase
{
    public function testAssembler(): void
    {
        $order = OrderFactory::random();

        $expectedSteps = array_map(function (Step $step) {
            return new StepDto(
                $step->position()->value(),
                $step->type()->value(),
                $step->exchangeId()->value(),
                $step->symbol()->value(),
                $step->value()->value(),
                $step->dependsOf() !== null ? $step->dependsOf()->value() : null
            );
        }, $order->steps());

        $expectedDto = new OrderDto($order->id()->value(), $expectedSteps);

        self::assertEquals($expectedDto, (new OrderDtoAssembler())->writeDto($order));
    }
}
