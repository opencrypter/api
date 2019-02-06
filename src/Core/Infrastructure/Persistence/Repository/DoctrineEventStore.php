<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Repository;

use Core\Domain\Event\Event;
use Core\Domain\Event\EventStore;
use Core\Domain\Event\StoredEvent;
use Core\Domain\Id;

class DoctrineEventStore extends DoctrineRepository implements EventStore
{
    /**
     * @return string
     */
    protected function entityClassName(): string
    {
        return StoredEvent::class;
    }

    /**
     * @param Event $event
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function append(Event $event): void
    {
        $lastStoredEvent = $this->lastOfAggregateId($event->aggregateRootId());
        $version         = $lastStoredEvent ? $lastStoredEvent->nextVersion() : 1;

        $storedEvent = new StoredEvent(
            $event->aggregateRootId()->value(),
            \get_class($event),
            $version,
            $event->payload(),
            $event->occurredOn()
        );

        $this->persistAndFlush($storedEvent);
    }

    /**
     * @param Id $id
     * @return StoredEvent|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function lastOfAggregateId(Id $id): ?StoredEvent
    {
        return $this
            ->repository()
            ->createQueryBuilder('e')
            ->where('e.aggregateRootId = :id')
            ->setParameter('id', $id->value())
            ->orderBy('e.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
