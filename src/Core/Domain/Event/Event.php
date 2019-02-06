<?php
declare(strict_types=1);

namespace Core\Domain\Event;

use Core\Domain\Id;

interface Event
{
    public function aggregateRootId(): Id;

    public function payload(): array;

    public function occurredOn(): \DateTimeImmutable;
}
