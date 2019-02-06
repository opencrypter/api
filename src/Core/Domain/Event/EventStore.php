<?php
declare(strict_types=1);

namespace Core\Domain\Event;

use Core\Domain\Id;

interface EventStore
{
    public function append(Event $event): void;

    public function lastOfAggregateId(Id $id): ?StoredEvent;
}
