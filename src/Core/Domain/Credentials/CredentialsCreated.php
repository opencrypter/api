<?php
declare(strict_types=1);

namespace Core\Domain\Credentials;

use Core\Domain\Event\Event;
use Core\Domain\Event\OccurredOn as OccurredOnAlias;
use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Id;
use Core\Domain\Name;

class CredentialsCreated implements Event
{
    /**
     * @var CredentialsId
     */
    private $id;

    /**
     * @var Name
     */
    private $name;

    /**
     * @var ExchangeId
     */
    private $exchangeId;

    /**
     * @var OccurredOnAlias
     */
    private $occurredOn;

    /**
     * CredentialsCreated constructor.
     *
     * @param CredentialsId $id
     * @param Name          $name
     * @param ExchangeId    $exchangeId
     */
    private function __construct(CredentialsId $id, Name $name, ExchangeId $exchangeId)
    {
        $this->id         = $id;
        $this->name       = $name;
        $this->exchangeId = $exchangeId;
        $this->occurredOn = OccurredOnAlias::now();
    }

    public static function create(Credentials $credentials): self
    {
        return new self($credentials->id(), $credentials->name(), $credentials->exchangeId());
    }

    public function aggregateRootId(): Id
    {
        return $this->id;
    }

    public function payload(): array
    {
        return [
            'id'         => $this->id->value(),
            'name'       => $this->name->value(),
            'exchangeId' => $this->exchangeId->value(),
        ];
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn->value();
    }
}
