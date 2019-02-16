<?php
declare(strict_types=1);

namespace Tests\Util\Mock;

use Core\Domain\Order\Order;
use Core\Domain\Order\OrderId;
use Core\Domain\Order\OrderRepository;

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
            ->shouldBeCalledOnce();

        return $this;
    }

    public function shouldSave(Order $order): self
    {
        $this->prophecy()
            ->save($order)
            ->shouldBeCalledOnce();

        return $this;
    }
}
