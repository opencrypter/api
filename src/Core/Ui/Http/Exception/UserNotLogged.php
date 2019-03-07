<?php
declare(strict_types=1);

namespace Core\Ui\Http\Exception;

use Core\Ui\UiException;
use Throwable;

class UserNotLogged extends \Exception implements UiException
{
    public function __construct(
        string $message = 'There is not any active user',
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
