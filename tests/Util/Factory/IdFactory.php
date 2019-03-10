<?php
declare(strict_types=1);

namespace Tests\Util\Factory;

use Core\Domain\Order\OrderId;
use Faker\Factory;

class IdFactory
{
    public static function orderId(): OrderId
    {
        return new OrderId(Factory::create()->uuid);
    }
}
