<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Application\Order;

use Core\Application\Order\GetOrder;
use Core\Application\Order\GetOrderHandler;
use Core\Application\Order\OrderDoesNotBelongToTheUser;
use Core\Application\Order\OrderDtoAssembler;
use Core\Application\Order\OrderNotFound;
use Core\Domain\Order\OrderRepository;
use Tests\Unit\Core\TestCase;
use Tests\Util\Factory\OrderFactory;
use Tests\Util\Factory\StepFactory;
use Tests\Util\Mock\OrderRepositoryMock;

class GetOrderHandlerTest extends TestCase
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
     * @var GetOrderHandler
     */
    private $handler;

    protected function setUp()
    {
        $this->orderRepositoryMock = new OrderRepositoryMock($this->prophesize(OrderRepository::class));
        $this->dtoAssembler        = new OrderDtoAssembler();
        $this->handler             = new GetOrderHandler($this->orderRepositoryMock->reveal(), $this->dtoAssembler);
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

        $order = OrderFactory::create($this->faker()->uuid, $this->faker()->uuid, $steps);

        $this->orderRepositoryMock
            ->shouldFindOrderOfId($order->id(), $order);

        self::assertEquals(
            $this->dtoAssembler->writeDto($order),
            $this->handler->__invoke(new GetOrder($order->id()->value(), $order->userId()->value()))
        );
    }

    /**
     * @throws \Throwable
     */
    public function testExceptionWhenOrderDoesNotExist(): void
    {
        $this->expectException(OrderNotFound::class);

        $order = OrderFactory::random();

        $this->orderRepositoryMock
            ->shouldFindOrderOfId($order->id(), null);

        $this->handler->__invoke(new GetOrder($order->id()->value(), $order->userId()->value()));
    }

    /**
     * @throws \Throwable
     */
    public function testExceptionWhenOrderDoesNotBelongToTheUser(): void
    {
        $this->expectException(OrderDoesNotBelongToTheUser::class);

        $order = OrderFactory::random();

        $this->orderRepositoryMock
            ->shouldFindOrderOfId($order->id(), $order);

        $this->handler->__invoke(new GetOrder($order->id()->value(), $this->faker()->uuid));
    }
}
