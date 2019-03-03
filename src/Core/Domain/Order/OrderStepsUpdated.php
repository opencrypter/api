<?php
declare(strict_types=1);

namespace Core\Domain\Order;

use Core\Domain\Event\Event;
use Core\Domain\Event\OccurredOn;
use Core\Domain\Id;
use Core\Domain\Order\Step\Step;

class OrderStepsUpdated implements Event
{
    /**
     * @var OrderId
     */
    private $id;

    /**
     * @var Step[]
     */
    private $steps;

    /**
     * @var OccurredOn
     */
    private $occurredOn;

    /**
     * @param Order $order
     * @return OrderStepsUpdated
     */
    public static function create(Order $order): self
    {
        return new self($order->id(), $order->steps());
    }

    /**
     * OrderStepsUpdated constructor.
     *
     * @param OrderId $id
     * @param array   $steps
     */
    private function __construct(OrderId $id, array $steps)
    {
        $this->id         = $id;
        $this->steps      = $steps;
        $this->occurredOn = OccurredOn::now();
    }

    /**
     * @return Id
     */
    public function aggregateRootId(): Id
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function payload(): array
    {
        return [
            'id'        => $this->id->value(),
            'steps'     => array_map(function (Step $step) {
                return [
                    'position'   => $step->position()->value(),
                    'type'       => $step->type()->value(),
                    'exchangeId' => $step->exchangeId()->value(),
                    'symbol'     => $step->symbol()->value(),
                    'value'      => $step->value()->value(),
                    'dependsOf'  => $step->dependsOf() !== null ? $step->dependsOf()->value() : null,
                    'createdAt'  => $step->createdAt()->format(),
                ];
            }, $this->steps)
        ];
    }

    /**
     * @return \DateTimeImmutable
     */
    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn->value();
    }
}
