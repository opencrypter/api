<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Application\Order;

use Core\Application\Order\DeleteOrder;
use Core\Application\Order\DeleteOrderCommandHandler;
use Core\Application\Order\ExecutedOrderCannotBeDeleted;
use Core\Application\Order\OrderDoesNotBelongToTheUser;
use Core\Application\Order\OrderNotFound;
use Core\Domain\Order\OrderRepository;
use Tests\Unit\Core\TestCase;
use Tests\Util\Factory\IdFactory;
use Tests\Util\Factory\OrderFactory;
use Tests\Util\Factory\StepFactory;
use Tests\Util\Mock\OrderRepositoryMock;

class DeleteOrderCommandHandlerTest extends TestCase
{
    /**
     * @var OrderRepositoryMock
     */
    private $orderRepositoryMock;

    /**
     * @var DeleteOrderCommandHandler
     */
    private $handler;

    protected function setUp()
    {
        $this->orderRepositoryMock = new OrderRepositoryMock($this->prophesize(OrderRepository::class));

        $this->handler = new DeleteOrderCommandHandler($this->orderRepositoryMock->reveal());
    }

    /**
     * @throws \Throwable
     */
    public function testHandler(): void
    {
        $order = OrderFactory::random();

        $this->orderRepositoryMock
            ->shouldFindOrderOfId($order->id(), $order)
            ->shouldDelete($order);

        $this->handler->__invoke(new DeleteOrder($order->id()->value(), $order->userId()->value()));
    }

    /**
     * @throws \Throwable
     */
    public function testExceptionWhenOrderDoesNotExist(): void
    {
        $this->expectException(OrderNotFound::class);
        $this->expectExceptionCode(404);

        $orderId = IdFactory::orderId();

        $this->orderRepositoryMock->shouldFindOrderOfId($orderId, null);

        $this->handler->__invoke(new DeleteOrder($orderId->value(), $this->uuid()));
    }

    /**
     * @throws \Throwable
     */
    public function testExceptionWhenOrderIsPartiallyExecuted(): void
    {
        $this->expectException(ExecutedOrderCannotBeDeleted::class);
        $this->expectExceptionCode(409);

        $order = OrderFactory::withSteps([
            StepFactory::withPosition(1)->markAsExecuted(),
            StepFactory::withPosition(2),
        ]);

        $this->orderRepositoryMock->shouldFindOrderOfId($order->id(), $order);

        $this->handler->__invoke(new DeleteOrder($order->id()->value(), $order->userId()->value()));
    }

    /**
     * @throws \Throwable
     */
    public function testExceptionWhenOrderDoesNotBelongToTheUser(): void
    {
        $this->expectException(OrderDoesNotBelongToTheUser::class);
        $this->expectExceptionCode(404);

        $order = OrderFactory::random();

        $this->orderRepositoryMock->shouldFindOrderOfId($order->id(), $order);

        $this->handler->__invoke(new DeleteOrder($order->id()->value(), $this->uuid()));
    }
}
