<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Application\Order;

use Core\Application\Order\CreateOrder;
use Core\Application\Order\CreateOrderHandler;
use Core\Application\Order\DuplicatedOrder;
use Core\Application\Order\OrderDtoAssembler;
use Core\Domain\Order\OrderRepository;
use Tests\Unit\Core\TestCase;
use Tests\Util\Factory\OrderFactory;
use Tests\Util\Factory\StepFactory;
use Tests\Util\Mock\OrderRepositoryMock;

class CreateOrderHandlerTest extends TestCase
{
    /**
     * @var OrderRepositoryMock
     */
    private $orderRepositoryMock;

    /**
     * @var OrderDtoAssembler
     */
    private $dtoAssembler;

    /**
     * @var CreateOrderHandler
     */
    private $handler;

    protected function setUp()
    {
        $this->orderRepositoryMock = new OrderRepositoryMock($this->prophesize(OrderRepository::class));
        $this->dtoAssembler        = new OrderDtoAssembler();
        $this->handler             = new CreateOrderHandler(
            $this->orderRepositoryMock->reveal(),
            $this->dtoAssembler
        );
    }

    /**
     * @throws \Throwable
     */
    public function testHandler(): void
    {
        $steps = [
            StepFactory::randomArray(),
            StepFactory::randomArray(),
        ];

        $expectedOrder = OrderFactory::create($this->faker()->uuid, $this->faker()->uuid, $steps);

        $this->orderRepositoryMock
            ->shouldFindOrderOfId($expectedOrder->id(), null)
            ->shouldSave($expectedOrder);

        $order = $this->handler->__invoke(new CreateOrder(
            $expectedOrder->id()->value(),
            $expectedOrder->userId()->value(),
            $steps
        ));

        self::assertEquals($this->dtoAssembler->writeDto($expectedOrder), $order);
    }

    /**
     * @throws \Throwable
     */
    public function testExceptionWhenOrderAlreadyExists(): void
    {
        $this->expectException(DuplicatedOrder::class);

        $order = OrderFactory::random();

        $this->orderRepositoryMock
            ->shouldFindOrderOfId($order->id(), $order);

        $this->handler->__invoke(new CreateOrder($order->id()->value(), $order->userId()->value(), []));
    }
}
