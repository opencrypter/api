<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Application\Order;

use Core\Application\Order\OrderDtoAssembler;
use Core\Application\Order\OrderNotFound;
use Core\Application\Order\UpdateOrder;
use Core\Application\Order\UpdateOrderHandler;
use Core\Domain\Order\OrderRepository;
use Core\Domain\Order\Step\Type;
use Tests\Unit\Core\TestCase;
use Tests\Util\Factory\OrderFactory;
use Tests\Util\Factory\StepFactory;
use Tests\Util\Mock\OrderRepositoryMock;

class UpdateOrderHandlerTest extends TestCase
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
     * @var UpdateOrderHandler
     */
    private $handler;

    protected function setUp()
    {
        $this->orderRepositoryMock = new OrderRepositoryMock($this->prophesize(OrderRepository::class));
        $this->dtoAssembler        = new OrderDtoAssembler();
        $this->handler             = new UpdateOrderHandler($this->orderRepositoryMock->reveal(), $this->dtoAssembler);
    }

    /**
     * @throws \Throwable
     */
    public function testHandler(): void
    {
        $stepPosition = 1;
        $stepType     = Type::WAIT_PRICE;
        $exchangeId   = $this->faker()->uuid;
        $symbol       = 'BTCUSD';
        $value        = 1;

        $existingOrder = OrderFactory::random();
        $expectedOrder = OrderFactory::copyOf($existingOrder);

        $expectedOrder->updateSteps([StepFactory::create(
            $stepPosition,
            $stepType,
            $exchangeId,
            $symbol,
            $value
        )]);

        $this->orderRepositoryMock
            ->shouldFindOrderOfId($existingOrder->id(), $existingOrder)
            ->shouldSave($expectedOrder);

        $order = $this->handler->__invoke(new UpdateOrder(
            $expectedOrder->id()->value(),
            $expectedOrder->userId()->value(),
            [StepFactory::createArray(
                $stepPosition,
                $stepType,
                $exchangeId,
                $symbol,
                $value
            )]
        ));

        self::assertEquals($this->dtoAssembler->writeDto($expectedOrder), $order);
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

        $this->handler->__invoke(new UpdateOrder($order->id()->value(), $order->userId()->value(), []));
    }

    /**
     * @throws \Throwable
     */
    public function testExceptionWhenOrderDoesNotBelongToTheUser(): void
    {
        $this->expectException(OrderNotFound::class);

        $order = OrderFactory::random();

        $this->orderRepositoryMock
            ->shouldFindOrderOfId($order->id(), $order);

        $this->handler->__invoke(new UpdateOrder($order->id()->value(), $this->faker()->uuid, []));
    }
}
