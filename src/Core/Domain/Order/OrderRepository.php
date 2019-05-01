<?php
declare(strict_types=1);

namespace Core\Domain\Order;

use Core\Domain\User\UserId;

interface OrderRepository
{
    /**
     * @param OrderId $id
     * @return Order|null
     */
    public function orderOfId(OrderId $id): ?Order;

    /**
     * @param UserId $userId
     * @return Order[]
     */
    public function ordersOfUserId(UserId $userId): array;

    /**
     * @param Order $order
     */
    public function save(Order $order): void;

    /**
     * @param Order $order
     */
    public function delete(Order $order): void;
}
