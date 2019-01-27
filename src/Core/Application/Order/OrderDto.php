<?php
declare(strict_types=1);

namespace Core\Application\Order;

class OrderDto
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var array
     */
    private $steps;

    public function __construct(string $id, array $steps)
    {
        $this->id    = $id;
        $this->steps = $steps;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getSteps(): array
    {
        return $this->steps;
    }
}
