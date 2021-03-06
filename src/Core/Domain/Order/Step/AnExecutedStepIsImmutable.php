<?php
declare(strict_types=1);

namespace Core\Domain\Order\Step;

use Core\Domain\DomainException;
use Core\Domain\Order\OrderId;
use Throwable;

class AnExecutedStepIsImmutable extends \Exception implements DomainException
{
    public function __construct(string $orderId, int $position, int $code = 409, Throwable $previous = null)
    {
        $message = "Step {$position} of the order {$orderId} cannot be modified because it has already been executed";
        parent::__construct($message, $code, $previous);
    }

    public static function create(OrderId $orderId, Position $position): self
    {
        return new self($orderId->value(), $position->value());
    }
}
