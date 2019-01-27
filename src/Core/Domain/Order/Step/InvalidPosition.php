<?php
declare(strict_types=1);

namespace Core\Domain\Order\Step;

use Core\Domain\DomainException;
use Throwable;

class InvalidPosition extends \Exception implements DomainException
{
    public function __construct(int $value, int $code = 400, Throwable $previous = null)
    {
        parent::__construct("'{$value}' is an invalid position", $code, $previous);
    }
}
