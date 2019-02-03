<?php
declare(strict_types=1);

namespace Core\Domain;

interface AggregateRoot
{
    /**
     * @return Id
     */
    public function id();
}
