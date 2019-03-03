<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Application\Order;

use Core\Application\Order\OrderDoesNotBelongToTheUser;
use Core\Application\Order\SaveOrder;
use Core\Application\Order\SaveOrderHandler;
use Core\Domain\Order\OrderRepository;
use Tests\Unit\Core\TestCase;
use Tests\Util\Factory\OrderFactory;
use Tests\Util\Factory\StepFactory;
use Tests\Util\Mock\OrderRepositoryMock;

class SaveOrderHandlerTest extends TestCase
{
    /**
     * @var OrderRepositoryMock
     */
    private $orderRepositoryMock;

    /**
     * @var SaveOrderHandler
     */
    private $handler;

    protected function setUp()
    {
        $this->orderRepositoryMock = new OrderRepositoryMock($this->prophesize(OrderRepository::class));
        $this->handler             = new SaveOrderHandler($this->orderRepositoryMock->reveal());
    }

    /**
     * @throws \Throwable
     */
    public function testANewOrder(): void
    {
        $steps = [
            StepFactory::randomArray(),
            StepFactory::randomArray(),
        ];

        $expectedOrder = OrderFactory::withSteps($steps);

        $this->orderRepositoryMock
            ->shouldFindOrderOfId($expectedOrder->id(), null)
            ->shouldSave($expectedOrder);

        $this->handler->__invoke(new SaveOrder(
            $expectedOrder->id()->value(),
            $expectedOrder->userId()->value(),
            $steps
        ));
    }

    /**
     * @throws \Throwable
     */
    public function testOrderUpdate(): void
    {
        $steps = [
            StepFactory::createArray(1, 'wait_price', $this->uuid(), 'BTCUSD', 3400),
            StepFactory::createArray(2, 'buy', $this->uuid(), 'BTCUSD', 2.3),
        ];

        $order    = OrderFactory::withoutEvents($this->uuid(), $this->uuid(), []);
        $expected = OrderFactory::withoutEvents($order->id()->value(), $order->userId()->value(), $steps);

        $this->orderRepositoryMock
            ->shouldFindOrderOfId($order->id(), $order)
            ->shouldSave($expected);

        $this->handler->__invoke(new SaveOrder(
            $order->id()->value(),
            $order->userId()->value(),
            $steps
        ));
    }

    /**
     * @throws \Throwable
     */
    public function testExceptionWhenOrderDoesNotBelongToTheUser(): void
    {
        $this->expectException(OrderDoesNotBelongToTheUser::class);

        $order = OrderFactory::random();

        $this->orderRepositoryMock->shouldFindOrderOfId($order->id(), $order);

        $this->handler->__invoke(new SaveOrder(
            $order->id()->value(),
            $this->uuid(),
            []
        ));
    }
}
