<?php
declare(strict_types=1);

namespace Core\Domain\Order;

use Core\Domain\CreatedAt;
use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Order\Step\Position;
use Core\Domain\Order\Step\Step;
use Core\Domain\Order\Step\Type;
use Core\Domain\Order\Step\Value;
use Core\Domain\Symbol;
use Doctrine\Common\Collections\ArrayCollection;

class Order
{
    /**
     * @var OrderId
     */
    private $id;

    /**
     * @var ArrayCollection|Step[]
     */
    private $steps;

    /**
     * @var CreatedAt
     */
    private $createdAt;

    /**
     * Order constructor.
     *
     * @param OrderId $id
     */
    public function __construct(OrderId $id)
    {
        $this->id        = $id;
        $this->steps     = new ArrayCollection();
        $this->createdAt = CreatedAt::now();
    }

    /**
     * @return OrderId
     */
    public function id(): OrderId
    {
        return $this->id;
    }

    /**
     * @return Step[]
     */
    public function steps(): array
    {
        return $this->steps->toArray();
    }

    public function addStep(
        Position $position,
        Type $type,
        ExchangeId $exchangeId,
        Symbol $symbol,
        Value $value,
        ?Position $dependsOf = null
    ): Step {
        $step = new Step($this, $position, $type, $exchangeId, $symbol, $value, $dependsOf);
        $this->steps->add($step);

        return $step;
    }
}
