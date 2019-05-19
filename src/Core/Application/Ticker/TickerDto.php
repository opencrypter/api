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
     * @var string
     */
    private $base;

    /**
     * @var string
     */
    private $quote;

    /**
     * TickerDto constructor.
     *
     * @param string $symbol
     * @param string $base
     * @param string $quote
     * @param float  $price
     */
    public function __construct(string $symbol, string $base, string $quote, float $price)
    {
        $this->symbol = $symbol;
        $this->base   = $base;
        $this->quote  = $quote;
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
     * @return string
     */
    public function base(): string
    {
        return $this->base;
    }

    /**
     * @return string
     */
    public function quote(): string
    {
        return $this->quote;
    }

    /**
     * @return float
     */
    public function price(): float
    {
        return $this->price;
    }
}
