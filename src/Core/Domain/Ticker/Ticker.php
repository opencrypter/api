<?php
declare(strict_types=1);

namespace Core\Domain\Ticker;

use Core\Domain\AggregateRoot;
use Core\Domain\CreatedAt;
use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Symbol;
use Core\Domain\UpdatedAt;

class Ticker extends AggregateRoot
{
    /**
     * @var TickerId
     */
    private $id;

    /**
     * @var Symbol
     */
    private $symbol;

    /**
     * @var ExchangeId
     */
    private $exchangeId;

    /**
     * @var Price
     */
    private $price;

    /**
     * @var CreatedAt
     */
    private $createdAt;

    /**
     * @var UpdatedAt
     */
    private $updatedAt;

    /**
     * Ticker constructor.
     *
     * @param TickerId   $id
     * @param Symbol     $symbol
     * @param ExchangeId $exchangeId
     * @param Price      $price
     */
    public function __construct(TickerId $id, Symbol $symbol, ExchangeId $exchangeId, Price $price)
    {
        $this->id         = $id;
        $this->symbol     = $symbol;
        $this->exchangeId = $exchangeId;
        $this->price      = $price;
        $this->createdAt  = CreatedAt::now();
    }

    /**
     * @return TickerId
     */
    public function id(): TickerId
    {
        return $this->id;
    }

    /**
     * @return Symbol
     */
    public function symbol(): Symbol
    {
        return $this->symbol;
    }

    /**
     * @return ExchangeId
     */
    public function exchangeId(): ExchangeId
    {
        return $this->exchangeId;
    }

    /**
     * @return Price
     */
    public function price(): Price
    {
        return $this->price;
    }

    public function updatePrice(Price $price): self
    {
        if (!$this->price->equals($price)) {
            $this->price     = $price;
            $this->markAsUpdated();
        }

        return $this;
    }

    private function markAsUpdated(): self
    {
        $this->updatedAt = UpdatedAt::now();

        return $this;
    }
}
