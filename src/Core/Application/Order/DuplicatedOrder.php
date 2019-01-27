<?php
declare(strict_types=1);

namespace Core\Application\Order;

use Core\Application\ApplicationException;
use Core\Domain\Order\OrderId;
use Throwable;

class DuplicatedOrder extends \Exception implements ApplicationException
{
    public function __construct(OrderId $orderId, int $code = 409, Throwable $previous = null)
    {
        parent::__construct("The order with id {$orderId->value()} already exists", $code, $previous);
    }
}
