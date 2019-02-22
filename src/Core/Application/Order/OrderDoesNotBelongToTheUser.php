<?php
declare(strict_types=1);

namespace Core\Application\Order;

use Core\Application\ApplicationException;
use Core\Domain\Order\OrderId;
use Core\Domain\User\UserId;
use PHPUnit\Runner\Exception;
use Throwable;

class OrderDoesNotBelongToTheUser extends Exception implements ApplicationException
{
    public function __construct(OrderId $orderId, UserId $userId, int $code = 404, Throwable $previous = null)
    {
        $message = sprintf("The order %s does not belong to the user %s", $orderId->value(), $userId->value());

        parent::__construct($message, $code, $previous);
    }
}
