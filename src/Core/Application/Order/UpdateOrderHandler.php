<?php
declare(strict_types=1);

namespace Core\Application\Order;

use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Order\OrderId;
use Core\Domain\Order\OrderRepository;
use Core\Domain\Order\Step\Position;
use Core\Domain\Order\Step\Step;
use Core\Domain\Order\Step\Type;
use Core\Domain\Order\Step\Value;
use Core\Domain\Symbol;
use Core\Domain\User\UserId;

class UpdateOrderHandler
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
     * @param UpdateOrder $command
     * @return OrderDto
     * @throws OrderNotFound
     * @throws \Core\Domain\Order\Step\AnExecutedStepCannotBeRemoved
     */
    public function __invoke(UpdateOrder $command): OrderDto
    {
        $orderId = new OrderId($command->id());
        $userId  = new UserId($command->userId());
        $steps   = $this->createSteps($command->steps());

        $order = $this->repository->orderOfId($orderId);

        if ($order === null || !$order->belongsTo($userId)) {
            throw new OrderNotFound($orderId);
        }

        $order->updateSteps($steps);

        $this->repository->save($order);

        return $this->dtoAssembler->writeDto($order);
    }

    /**
     * @param array $stepDtos
     * @return array
     */
    private function createSteps(array $stepDtos): array
    {
        return array_map(function (StepDto $stepDto) {
            return new Step(
                new Position($stepDto->getPosition()),
                new Type($stepDto->getType()),
                new ExchangeId($stepDto->getExchangeId()),
                new Symbol($stepDto->getSymbol()),
                new Value($stepDto->getValue()),
                $stepDto->getDependsOf() !== null ? new Position($stepDto->getDependsOf()) : null
            );
        }, $stepDtos);
    }
}
