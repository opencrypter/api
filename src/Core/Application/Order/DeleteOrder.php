<?php
declare(strict_types=1);

namespace Core\Application\Order;

class DeleteOrder
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $userId;

    /**
     * DeleteOrder constructor.
     *
     * @param string $id
     */
    public function __construct(string $id, string $userId)
    {
        $this->id     = $id;
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function userId(): string
    {
        return $this->userId;
    }
}
