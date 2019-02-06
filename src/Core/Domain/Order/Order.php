<?php
declare(strict_types=1);

namespace Core\Domain\Order;

use Core\Domain\AggregateRoot;
use Core\Domain\CreatedAt;
use Core\Domain\Order\Step\Step;
use Doctrine\Common\Collections\ArrayCollection;

class Order extends AggregateRoot
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
     * @param array   $steps
     */
    public function __construct(OrderId $id, array $steps)
    {
        $this->id = $id;
        $this->addSteps($steps);
        $this->createdAt = CreatedAt::now();

        $this->record(OrderCreated::create($this));
    }

    private function addSteps(array $steps): void
    {
        $this->steps = new ArrayCollection();
        foreach ($steps as $step) {
            $step->setOrder($this);
            $this->steps->add($step);
        }
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

    /**
     * @return CreatedAt
     */
    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }
}
