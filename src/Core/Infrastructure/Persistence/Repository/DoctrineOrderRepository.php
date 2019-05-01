<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Repository;

use Core\Domain\Order\Order;
use Core\Domain\Order\OrderId;
use Core\Domain\Order\OrderRepository;
use Core\Domain\User\UserId;

class DoctrineOrderRepository extends DoctrineRepository implements OrderRepository
{
    protected function entityClassName(): string
    {
        return Order::class;
    }

    /**
     * @param OrderId $id
     * @return Order|null
     */
    public function orderOfId(OrderId $id): ?Order
    {
        return $this->repository()->find($id);
    }

    /**
     * @param UserId $userId
     * @return Order[]
     */
    public function ordersOfUserId(UserId $userId): array
    {
        return $this
            ->repository()
            ->findBy(['userId' => $userId], ['createdAt' => 'DESC']);
    }

    /**
     * @param Order $order
     */
    public function save(Order $order): void
    {
        foreach ($order->steps() as $step) {
            $step->setOrder($order);
        }

        $this->manager()->persist($order);
        $this->manager()->flush($order);
    }

    /**
     * @param Order $order
     */
    public function delete(Order $order): void
    {
        $this->manager()->remove($order);
        $this->manager()->flush($order);
    }
}
