<?php
declare(strict_types=1);

namespace Core\Application\Ticker;

use Core\Application\ApplicationException;
use Exception;
use Throwable;

class TickerApiNotFound extends Exception implements ApplicationException
{
    public function __construct(string $name, $code = 0, Throwable $previous = null)
    {
        parent::__construct("There isn't any api named \"{$name}\"", $code, $previous);
    }
}
