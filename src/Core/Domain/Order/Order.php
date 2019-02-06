<?php
declare(strict_types=1);

namespace Core\Domain\Order;

use Core\Domain\AggregateRoot;
use Core\Domain\CreatedAt;
use Core\Domain\Order\Step\Step;
use Core\Domain\User\UserId;
use Doctrine\Common\Collections\ArrayCollection;

class Order extends AggregateRoot
{
    /**
     * @var OrderId
     */
    private $id;

    /**
     * @var UserId
     */
    private $userId;

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
     * @param UserId  $userId
     * @param array   $steps
     */
    public function __construct(OrderId $id, UserId $userId, array $steps)
    {
        $this->id = $id;
        $this->userId = $userId;
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
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
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
