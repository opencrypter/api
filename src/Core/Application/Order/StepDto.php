<?php
declare(strict_types=1);

namespace Core\Application\Order;

class StepDto
{
    /**
     * @var int
     */
    private $position;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $exchangeId;

    /**
     * @var string
     */
    private $symbol;

    /**
     * @var float
     */
    private $value;

    /**
     * @var int|null
     */
    private $dependsOf;

    /**
     * StepDto constructor.
     *
     * @param int      $position
     * @param string   $type
     * @param string   $exchangeId
     * @param string   $symbol
     * @param float    $value
     * @param int|null $dependsOf
     */
    public function __construct(
        int $position,
        string $type,
        string $exchangeId,
        string $symbol,
        float $value,
        ?int $dependsOf = null
    ) {
        $this->position = $position;
        $this->type = $type;
        $this->exchangeId = $exchangeId;
        $this->symbol = $symbol;
        $this->value = $value;
        $this->dependsOf = $dependsOf;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getExchangeId(): string
    {
        return $this->exchangeId;
    }

    /**
     * @return string
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @return int|null
     */
    public function getDependsOf(): ?int
    {
        return $this->dependsOf;
    }
}
