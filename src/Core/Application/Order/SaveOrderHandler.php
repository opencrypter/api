<?php
declare(strict_types=1);

namespace Core\Application\Order;

use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Order\Order;
use Core\Domain\Order\OrderId;
use Core\Domain\Order\OrderRepository;
use Core\Domain\Order\Step\Position;
use Core\Domain\Order\Step\Step;
use Core\Domain\Order\Step\Type;
use Core\Domain\Order\Step\Value;
use Core\Domain\Symbol;
use Core\Domain\User\UserId;

class SaveOrderHandler
{
    /**
     * @var OrderRepository
     */
    private $repository;

    /**
     * SaveOrderHandler constructor.
     *
     * @param OrderRepository $repository
     */
    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param SaveOrder $command
     * @throws \Core\Domain\Order\Step\AnExecutedStepIsImmutable
     */
    public function __invoke(SaveOrder $command): void
    {
        $orderId = new OrderId($command->id());
        $userId  = new UserId($command->userId());
        $steps   = $this->createSteps($command->steps());

        $order = $this->repository->orderOfId($orderId);

        if (!$order) {
            $this->repository->save(new Order($orderId, $userId, $steps));

            return;
        }

        $this->assertOrderBelongsToTheUser($order, $userId);

        $order->updateSteps($steps);

        $this->repository->save($order);
    }

    /**
     * @param array $stepDtos
     * @return Step[]
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

    /**
     * @param Order  $order
     * @param UserId $userId
     */
    private function assertOrderBelongsToTheUser(Order $order, UserId $userId): void
    {
        if (!$order->userId()->equalsTo($userId)) {
            throw new OrderDoesNotBelongToTheUser($order->id(), $userId);
        }
    }
}
