<?php
declare(strict_types=1);

namespace Core\Domain\Exchange;

use Core\Domain\DomainException;
use Throwable;

final class InvalidName extends \Exception implements DomainException
{
    /**
     * InvalidName constructor.
     *
     * @param string         $invalidName Given invalid name.
     * @param int            $code        Exception code.
     * @param Throwable|null $previous    Previous exception.
     */
    public function __construct(string $invalidName, int $code = 400, Throwable $previous = null)
    {
        parent::__construct("{$invalidName} is an invalid name", $code, $previous);
    }
}
