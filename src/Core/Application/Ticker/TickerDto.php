<?php
declare(strict_types=1);

namespace Core\Application\Ticker;

class TickerDto
{
    /**
     * @var string
     */
    private $symbol;

    /**
     * @var float
     */
    private $price;

    /**
     * TickerDto constructor.
     *
     * @param string $symbol
     * @param float  $price
     */
    public function __construct(string $symbol, float $price)
    {
        $this->symbol = $symbol;
        $this->price  = $price;
    }

    /**
     * @return string
     */
    public function symbol(): string
    {
        return $this->symbol;
    }

    /**
     * @return float
     */
    public function price(): float
    {
        return $this->price;
    }
}
