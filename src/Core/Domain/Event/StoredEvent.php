<?php
declare(strict_types=1);

namespace Core\Domain\Event;

class StoredEvent
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $aggregateRootId;

    /**
     * @var string
     */
    private $type;

    /**
     * @var int
     */
    private $version;

    /**
     * @var array
     */
    private $payload;

    /**
     * @var \DateTimeImmutable
     */
    private $occurredOn;

    /**
     * Event constructor.
     *
     * @param string             $aggregateRootId
     * @param string             $type
     * @param int                $version
     * @param array              $payload
     * @param \DateTimeImmutable $occurredOn
     */
    public function __construct(
        string $aggregateRootId,
        string $type,
        int $version,
        array $payload,
        \DateTimeImmutable $occurredOn
    ) {

        $this->aggregateRootId = $aggregateRootId;
        $this->type            = $type;
        $this->version         = $version;
        $this->payload         = $payload;
        $this->occurredOn      = $occurredOn;
    }

    /**
     * @return string
     */
    public function aggregateRootId(): string
    {
        return $this->aggregateRootId;
    }

    public function nextVersion(): int
    {
        return $this->version + 1;
    }
}
