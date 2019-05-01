<?php
declare(strict_types=1);

namespace Core\Ui\Ws\Exception;

use Core\Ui\UiException;
use Exception;
use Throwable;

class InvalidEventKey extends Exception implements UiException
{
    public function __construct(string $eventKey, $code = 400, Throwable $previous = null)
    {
        parent::__construct("The event '{$eventKey}' is invalid", $code, $previous);
    }
}
