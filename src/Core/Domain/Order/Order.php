<?php
declare(strict_types=1);

namespace Core\Domain\Order;

use Doctrine\Common\Collections\ArrayCollection;

class Order
{
    /**
     * @var OrderId
     */
    private $id;

    /**
     * @var ArrayCollection|OrderStep[]
     */
    private $steps;

    /**
     * Order constructor.
     *
     * @param OrderId     $id
     * @param OrderStep[] $steps
     */
    public function __construct(OrderId $id, array $steps)
    {
        $this->id    = $id;
        $this->steps = new ArrayCollection($steps);
    }
}
