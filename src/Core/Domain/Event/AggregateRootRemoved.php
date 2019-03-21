<?php
declare(strict_types=1);

namespace Core\Domain\Event;

use Core\Domain\Id;

class AggregateRootRemoved implements Event
{
    /**
     * @var Id
     */
    private $id;

    /**
     * @var OccurredOn
     */
    private $occurredOn;

    /**
     * AggregateRootRemoved constructor.
     *
     * @param Id $id
     */
    public function __construct(Id $id)
    {
        $this->id         = $id;
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
            'id' => $this->id->value(),
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
