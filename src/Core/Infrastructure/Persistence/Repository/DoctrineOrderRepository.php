<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Repository;

use Core\Domain\Order\Order;
use Core\Domain\Order\OrderId;
use Core\Domain\Order\OrderRepository;

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
     * @param Order $order
     */
    public function save(Order $order): void
    {
        $this->manager()->persist($order);
        $this->manager()->flush($order);
    }
}
