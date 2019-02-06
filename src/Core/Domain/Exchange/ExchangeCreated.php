<?php
declare(strict_types=1);

namespace Core\Domain\Exchange;

use Core\Domain\CreatedAt;
use Core\Domain\Event\Event;
use Core\Domain\Event\OccurredOn;
use Core\Domain\Id;

class ExchangeCreated implements Event
{
    /**
     * @var ExchangeId
     */
    private $id;

    /**
     * @var Name
     */
    private $name;

    /**
     * @var Symbols
     */
    private $symbols;

    /**
     * @var CreatedAt
     */
    private $createdAt;

    /**
     * @var OccurredOn
     */
    private $occurredOn;

    /**
     * @param Exchange $exchange
     * @return ExchangeCreated
     */
    public static function create(Exchange $exchange): self
    {
        return new self($exchange->id(), $exchange->name(), $exchange->symbols(), $exchange->createdAt());
    }

    /**
     * ExchangeCreated constructor.
     *
     * @param ExchangeId $id
     * @param Name       $name
     * @param Symbols    $symbols
     * @param CreatedAt  $createdAt
     */
    private function __construct(ExchangeId $id, Name $name, Symbols $symbols, CreatedAt $createdAt)
    {
        $this->id         = $id;
        $this->name       = $name;
        $this->symbols    = $symbols;
        $this->createdAt  = $createdAt;
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
            'id'        => $this->id->value(),
            'name'      => $this->name->value(),
            'symbols'   => $this->symbols->toArray(),
            'createdAt' => $this->createdAt->format(),
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
