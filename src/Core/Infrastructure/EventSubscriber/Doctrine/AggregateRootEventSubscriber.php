<?php
declare(strict_types=1);

namespace Core\Infrastructure\EventSubscriber\Doctrine;

use Core\Domain\AggregateRoot;
use Core\Domain\Event\AggregateRootRemoved;
use Core\Domain\Event\Event;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class AggregateRootEventSubscriber implements EventSubscriber
{
    /**
     * @var Event[]
     */
    private $collectedEvents = [];

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove,
        ];
    }

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
        $entity = $event->getObject();

        if (!$entity instanceof AggregateRoot) {
            return;
        }

        $this->collectedEvents[] = new AggregateRootRemoved($entity->id());
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
