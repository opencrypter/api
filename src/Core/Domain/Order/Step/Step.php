<?php
declare(strict_types=1);

namespace Core\Domain\Order\Step;

use Core\Domain\CreatedAt;
use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Order\Order;
use Core\Domain\Symbol;

class Step
{
    /**
     * @var Order
     */
    private $order;

    /**
     * @var Position
     */
    private $position;

    /**
     * @var Type
     */
    private $type;

    /**
     * @var ExchangeId
     */
    private $exchangeId;

    /**
     * @var Symbol
     */
    private $symbol;

    /**
     * @var Value
     */
    private $value;

    /**
     * @var Position|null
     */
    private $dependsOf;

    /**
     * @var CreatedAt
     */
    private $createdAt;

    /**
     * @var ExecutedAt|null
     */
    private $executedAt;

    public function __construct(
        Order $order,
        Position $position,
        Type $type,
        ExchangeId $exchangeId,
        Symbol $symbol,
        Value $value,
        ?Position $dependsOf = null
    ) {
        $this->order      = $order;
        $this->position   = $position;
        $this->type       = $type;
        $this->exchangeId = $exchangeId;
        $this->symbol     = $symbol;
        $this->value      = $value;
        $this->dependsOf  = $dependsOf;
        $this->createdAt  = CreatedAt::now();
    }

    /**
     * @return Order
     */
    public function order(): Order
    {
        return $this->order;
    }

    /**
     * @return Position
     */
    public function position(): Position
    {
        return $this->position;
    }

    /**
     * @return Type
     */
    public function type(): Type
    {
        return $this->type;
    }

    /**
     * @return ExchangeId
     */
    public function exchangeId(): ExchangeId
    {
        return $this->exchangeId;
    }

    /**
     * @return Symbol
     */
    public function symbol(): Symbol
    {
        return $this->symbol;
    }

    /**
     * @return Value
     */
    public function value(): Value
    {
        return $this->value;
    }

    /**
     * @return Position|null
     */
    public function dependsOf(): ?Position
    {
        return $this->dependsOf;
    }

    /**
     * @return CreatedAt
     */
    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }

    /**
     * @return ExecutedAt|null
     */
    public function executedAt(): ?ExecutedAt
    {
        return $this->executedAt;
    }
}
