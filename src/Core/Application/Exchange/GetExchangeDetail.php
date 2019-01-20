<?php
declare(strict_types=1);

namespace Core\Application\Exchange;

class GetExchangeDetail
{
    /**
     * @var string
     */
    private $exchangeId;

    public function __construct(string $exchangeId)
    {
        $this->exchangeId = $exchangeId;
    }

    /**
     * @return string
     */
    public function exchangeId(): string
    {
        return $this->exchangeId;
    }
}
