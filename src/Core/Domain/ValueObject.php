<?php
declare(strict_types=1);

namespace Core\Domain;

interface ValueObject
{
    /**
     * Scalar value.
     *
     * @return mixed
     */
    public function value();
}
