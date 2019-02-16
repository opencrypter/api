<?php
declare(strict_types=1);

namespace Core\Application\Order;

use Core\Application\ApplicationException;
use Core\Domain\Order\OrderId;
use Throwable;

class OrderNotFound extends \Exception implements ApplicationException
{
    public function __construct(OrderId $id, int $code = 404, Throwable $previous = null)
    {
        parent::__construct("order with id {$id->value()} not found", $code, $previous);
    }
}
