<?php
declare(strict_types=1);

namespace Core\Ui\Http\Exception;

use Core\Ui\UiException;
use Throwable;

class BadRequest extends \Exception implements UiException
{
    public function __construct(string $message, int $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function createWithErrors(array $errors): self
    {
        $errorMessages = [];
        foreach ($errors as $error) {
            $errorMessages[] = ['property' => $error['property'], 'message' => $error['message']];
        }

        return new self(\json_encode($errorMessages));
    }
}
