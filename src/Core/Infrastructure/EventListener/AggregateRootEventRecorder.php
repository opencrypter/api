<?php
declare(strict_types=1);

namespace Core\Infrastructure\EventListener;

use Core\Domain\AggregateRoot;
use Core\Domain\Event\Event;
use Doctrine\ORM\Event\LifecycleEventArgs;

class AggregateRootEventRecorder
{
    /**
     * @var Event[]
     */
    private $collectedEvents = [];

    /**
     * @param LifecycleEventArgs $event
     */
    public function postPersist(LifecycleEventArgs $event): void
    {
        $this->storeEvents($event);
    }

    /**
     * @param LifecycleEventArgs $event
     */
    public function postUpdate(LifecycleEventArgs $event): void
    {
        $this->storeEvents($event);
    }

    /**
     * @param LifecycleEventArgs $event
     */
    public function postRemove(LifecycleEventArgs $event): void
    {
        $this->storeEvents($event);
    }

    /**
     * @param LifecycleEventArgs $lifecycleEventArgs
     */
    private function storeEvents(LifecycleEventArgs $lifecycleEventArgs): void
    {
        $entity = $lifecycleEventArgs->getObject();

        if (!$entity instanceof AggregateRoot) {
            return;
        }

        foreach ($entity->releaseEvents() as $event) {
            $this->collectedEvents[] = $event;
        }
    }

    /**
     * @return Event[]
     */
    public function releaseEvents(): array
    {
        $events = $this->collectedEvents;
        $this->eraseEvents();

        return $events;
    }

    private function eraseEvents(): void
    {
        $this->collectedEvents = [];
    }
}
