<?php
declare(strict_types=1);

namespace Core\Application\Order;

class GetAllOrders
{
    /**
     * @var string
     */
    private $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function userId(): string
    {
        return $this->userId;
    }
}
