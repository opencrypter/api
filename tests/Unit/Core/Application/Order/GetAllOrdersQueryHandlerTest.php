<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Application\Order;

use Core\Application\Order\GetAllOrders;
use Core\Application\Order\GetAllOrdersQueryHandler;
use Core\Application\Order\OrderDtoAssembler;
use Core\Domain\Order\OrderRepository;
use Tests\Unit\Core\TestCase;
use Tests\Util\Factory\OrderFactory;
use Tests\Util\Mock\OrderRepositoryMock;

class GetAllOrdersQueryHandlerTest extends TestCase
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
     * @var GetAllOrdersQueryHandler
     */
    private $handler;

    protected function setUp()
    {
        $this->orderRepositoryMock = new OrderRepositoryMock($this->prophesize(OrderRepository::class));
        $this->dtoAssembler        = new OrderDtoAssembler();

        $this->handler = new GetAllOrdersQueryHandler($this->orderRepositoryMock->reveal(), $this->dtoAssembler);
    }

    /**
     * @throws \Throwable
     */
    public function testHandler(): void
    {
        $order = OrderFactory::random();

        $this->orderRepositoryMock->shouldFindOrdersOfUserId($order->userId(), [$order]);

        self::assertEquals(
            [$this->dtoAssembler->writeDto($order)],
            $this->handler->__invoke(new GetAllOrders($order->userId()->value()))
        );
    }
}
