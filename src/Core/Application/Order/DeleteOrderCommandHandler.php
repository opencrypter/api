<?php
declare(strict_types=1);

namespace Core\Application\Order;

use Core\Domain\Order\OrderId;
use Core\Domain\Order\OrderRepository;
use Core\Domain\User\UserId;

class DeleteOrderCommandHandler
{
    /**
     * @var OrderRepository
     */
    private $repository;

    /**
     * DeleteOrderCommandHandler constructor.
     *
     * @param OrderRepository $repository
     */
    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param DeleteOrder $command
     *
     * @throws OrderNotFound
     * @throws ExecutedOrderCannotBeDeleted
     */
    public function __invoke(DeleteOrder $command): void
    {
        $orderId = new OrderId($command->id());
        $userId  = new UserId($command->userId());

        $order = $this->repository->orderOfId($orderId);

        if ($order === null) {
            throw new OrderNotFound($orderId);
        }

        if (!$order->userId()->equals($userId)) {
            throw new OrderDoesNotBelongToTheUser($orderId, $userId);
        }

        if ($order->hasExecutedSteps()) {
            throw new ExecutedOrderCannotBeDeleted($orderId);
        }

        $this->repository->delete($order);
    }
}
