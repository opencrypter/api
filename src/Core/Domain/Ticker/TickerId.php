<?php
declare(strict_types=1);

namespace Core\Domain\Ticker;

use Core\Domain\Id;
use Core\Domain\InvalidId;
use Core\Domain\Order\InvalidTickerId;

class TickerId extends Id
{
    protected function exception(string $invalidValue): InvalidId
    {
        return new InvalidTickerId($invalidValue);
    }
}
