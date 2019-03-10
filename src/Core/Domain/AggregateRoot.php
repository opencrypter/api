<?php
declare(strict_types=1);

namespace Core\Domain;

use Core\Domain\Event\Event;

abstract class AggregateRoot
{
    /**
     * @var Event[]
     */
    private $events = [];

    /**
     * @return Id
     */
    abstract public function id();

    /**
     * @param Event $event
     */
    protected function record(Event $event): void
    {
        $this->events[\get_class($event)] = $event;
    }

    /**
     * @return Event[]
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
