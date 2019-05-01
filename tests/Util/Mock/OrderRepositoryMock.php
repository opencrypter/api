<?php
declare(strict_types=1);

namespace Tests\Util\Mock;

use Core\Domain\Order\Order;
use Core\Domain\Order\OrderId;
use Core\Domain\Order\OrderRepository;
use Core\Domain\User\UserId;

/**
 * @method OrderRepository reveal
 */
class OrderRepositoryMock extends Mock
{
    public function shouldFindOrderOfId(OrderId $id, ?Order $order): self
    {
        $this->prophecy()
            ->orderOfId($id)
            ->willReturn($order)
            ->shouldBeCalled();

        return $this;
    }

    public function shouldFindOrdersOfUserId(UserId $userId, array $orders): self
    {
        $this->prophecy()
            ->ordersOfUserId($userId)
            ->willReturn($orders)
            ->shouldBeCalled();

        return $this;
    }

    public function shouldSave(Order $order): self
    {
        $this->prophecy()
            ->save($order)
            ->shouldBeCalled();

        return $this;
    }
}
