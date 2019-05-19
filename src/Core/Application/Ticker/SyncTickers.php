<?php
declare(strict_types=1);

namespace Core\Application\Ticker;

class SyncTickers
{
    /**
     * @var string
     */
    private $exchangeName;

    public function __construct(string $exchangeName)
    {
        $this->exchangeName = $exchangeName;
    }

    /**
     * @return string
     */
    public function exchangeName(): string
    {
        return $this->exchangeName;
    }
}
