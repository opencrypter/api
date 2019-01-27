<?php
declare(strict_types=1);

namespace Core\Application\Order;

use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Order\Order;
use Core\Domain\Order\OrderId;
use Core\Domain\Order\OrderRepository;
use Core\Domain\Order\Step\Position;
use Core\Domain\Order\Step\Type;
use Core\Domain\Order\Step\Value;
use Core\Domain\Symbol;

class CreateOrderHandler
{
    /**
     * @var OrderRepository
     */
    private $repository;

    /**
     * @var OrderDtoAssembler
     */
    private $dtoAssembler;

    /**
     * CreateOrderHandler constructor.
     *
     * @param OrderRepository   $repository
     * @param OrderDtoAssembler $dtoAssembler
     */
    public function __construct(OrderRepository $repository, OrderDtoAssembler $dtoAssembler)
    {
        $this->repository = $repository;
        $this->dtoAssembler = $dtoAssembler;
    }

    /**
     * @param CreateOrder $command
     * @return OrderDto
     * @throws \Core\Domain\Order\Step\InvalidPosition
     * @throws \Core\Domain\Order\Step\InvalidType
     * @throws DuplicatedOrder
     */
    public function __invoke(CreateOrder $command): OrderDto
    {
        $orderId = new OrderId($command->id());

        if ($this->repository->orderOfId($orderId) !== null) {
            throw new DuplicatedOrder($orderId);
        }

        $order = $this->createOrder($command, $orderId);

        $this->repository->save($order);

        return $this->dtoAssembler->writeDto($order);
    }

    /**
     * @param CreateOrder $command
     * @param OrderId     $orderId
     * @return Order
     * @throws \Core\Domain\Order\Step\InvalidPosition
     * @throws \Core\Domain\Order\Step\InvalidType
     */
    private function createOrder(CreateOrder $command, OrderId $orderId): Order
    {
        $order = new Order($orderId);
        foreach ($command->steps() as $stepDto) {
            $order->addStep(
                new Position($stepDto->getPosition()),
                new Type($stepDto->getType()),
                new ExchangeId($stepDto->getExchangeId()),
                new Symbol($stepDto->getSymbol()),
                new Value($stepDto->getValue()),
                $stepDto->getDependsOf() !== null ? new Position($stepDto->getDependsOf()) : null
            );
        }

        return $order;
    }
}
