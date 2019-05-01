<?php
declare(strict_types=1);

namespace Core\Application\Order;

use Core\Application\ApplicationException;
use Core\Domain\Order\OrderId;
use Exception;
use Throwable;

class ExecutedOrderCannotBeDeleted extends Exception implements ApplicationException
{
    public function __construct(OrderId $id, int $code = 409, Throwable $previous = null)
    {
        parent::__construct("order with id {$id} has one or more executed steps so can't be deleted", $code, $previous);
    }
}
