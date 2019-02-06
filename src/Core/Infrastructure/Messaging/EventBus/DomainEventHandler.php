<?php
declare(strict_types=1);

namespace Core\Infrastructure\Messaging\EventBus;

use Core\Domain\Event\Event;
use Core\Domain\Event\EventStore;

class DomainEventHandler
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
