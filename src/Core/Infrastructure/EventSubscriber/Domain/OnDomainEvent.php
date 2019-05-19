<?php
declare(strict_types=1);

namespace Core\Infrastructure\EventSubscriber\Domain;

use Core\Domain\Event\Event;
use Core\Domain\Event\EventStore;

class OnDomainEvent
{
    /**
     * @var EventStore
     */
    private $repository;

    public function __construct(EventStore $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Event $event)
    {
        $this->repository->append($event);
    }
}
