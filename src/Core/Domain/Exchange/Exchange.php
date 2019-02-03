<?php
declare(strict_types=1);

namespace Core\Domain\Exchange;

use Core\Domain\CreatedAt;
use Core\Domain\AggregateRoot;
use Core\Domain\UpdatedAt;

final class Exchange implements AggregateRoot
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
     * @var UpdatedAt|null
     */
    private $updatedAt;

    /**
     * Exchange constructor.
     *
     * @param ExchangeId $id
     * @param Name       $name
     * @param Symbols    $symbols
     */
    public function __construct(ExchangeId $id, Name $name, Symbols $symbols)
    {
        $this->id        = $id;
        $this->name      = $name;
        $this->symbols   = $symbols;
        $this->createdAt = CreatedAt::now();
    }

    /**
     * @return ExchangeId
     */
    public function id(): ExchangeId
    {
        return $this->id;
    }

    /**
     * @return Name
     */
    public function name(): Name
    {
        return $this->name;
    }

    /**
     * @return Symbols
     */
    public function symbols(): Symbols
    {
        return $this->symbols;
    }
}
