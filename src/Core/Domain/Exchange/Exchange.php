<?php
declare(strict_types=1);

namespace Core\Domain\Exchange;

use Core\Domain\CreatedAt;
use Core\Domain\Entity;
use Core\Domain\Id;
use Core\Domain\UpdatedAt;

final class Exchange implements Entity
{
    /**
     * @var ExchangeId
     */
    private $id;

    /**
     * @var Name
     */
    private $name;

    /**
     * @var CreatedAt
     */
    private $createdAt;

    /**
     * @var UpdatedAt|null
     */
    private $updatedAt;

    /**
     * Exchange constructor.
     *
     * @param ExchangeId $id
     * @param Name       $name
     */
    public function __construct(ExchangeId $id, Name $name)
    {
        $this->id        = $id;
        $this->name      = $name;
        $this->createdAt = CreatedAt::now();
    }

    /**
     * @return ExchangeId
     */
    public function id(): ExchangeId
    {
        return $this->id;
    }

    /**
     * @return Name
     */
    public function name(): Name
    {
        return $this->name;
    }
}
