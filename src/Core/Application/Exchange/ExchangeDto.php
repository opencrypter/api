<?php
declare(strict_types=1);

namespace Core\Application\Exchange;

class ExchangeDto
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $symbols;

    /**
     * ExchangeDto constructor.
     *
     * @param string $id
     * @param string $name
     * @param array  $symbols
     */
    public function __construct(string $id, string $name, array $symbols)
    {
        $this->id      = $id;
        $this->name    = $name;
        $this->symbols = $symbols;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getSymbols(): array
    {
        return $this->symbols;
    }
}
