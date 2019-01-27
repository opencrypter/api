<?php
declare(strict_types=1);

namespace Core\Domain\Order;

interface OrderRepository
{
    /**
     * @param OrderId $id
     * @return Order|null
     */
    public function orderOfId(OrderId $id): ?Order;

    /**
     * @param Order $order
     */
    public function save(Order $order): void;
}
