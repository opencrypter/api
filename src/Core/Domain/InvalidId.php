<?php
declare(strict_types=1);

namespace Core\Domain;

use Throwable;

abstract class InvalidId extends \Exception implements DomainException
{
    /**
     * InvalidId constructor.
     *
     * @param string         $id       Related invalid id.
     * @param int            $code     Exception code
     * @param Throwable|null $previous Previous exception
     */
    public function __construct(string $id, int $code = 400, Throwable $previous = null)
    {
        parent::__construct("{$id} is an invalid id", $code, $previous);
    }
}
