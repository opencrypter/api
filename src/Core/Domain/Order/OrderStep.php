<?php
declare(strict_types=1);

namespace Core\Domain\Order;

use Core\Domain\CreatedAt;
use Core\Domain\Entity;
use Core\Domain\Symbol;

class OrderStep implements Entity
{
    /**
     * @var OrderStepId
     */
    private $id;

    /**
     * @var Order
     */
    private $order;

    /**
     * @var OrderStepType
     */
    private $type;

    /**
     * @var Symbol
     */
    private $symbol;

    /**
     * @var OrderValue
     */
    private $value;

    /**
     * @var CreatedAt
     */
    private $createdAt;

    /**
     * @var ExecutedAt|null
     */
    private $executedAt;

    public function __construct(OrderStepId $id, OrderStepType $type, Symbol $symbol, OrderValue $value)
    {
        $this->id        = $id;
        $this->type      = $type;
        $this->symbol    = $symbol;
        $this->value     = $value;
        $this->createdAt = CreatedAt::now();
    }

    /**
     * @return OrderStepId
     */
    public function id(): OrderStepId
    {
        return $this->id();
    }
}
